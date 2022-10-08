<?php
    class StatisticObject {
        public int $ordersCount = 0;
        public int $totalOrderValue = 0;
        public string $avgOrderValue = '';
        public int $commissionPaid = 0;
        public int $commissionPending = 0;
        public string $avgOrderQuantity = '';
        public string $avgOrderFrequency = '';
        public string $pamojaOrdersPercentage = '';

        public float $avgPamojaItemsPerOrder = 0; // Ratio
        public int $totalPamojaItemsCount = 0; // Integer
        public string $lifetimeTotalValueOfPamojaSales = '0'; // KSh
    }

    class AgentStatistics {
        const YESTERDAY = 'yesterday';
        const TODAY = 'today';
        const WEEK = 'week';
        const MONTH = 'month';
        const YEAR = 'year';

        private $wpdb;
        private $agentId;
        private $periods = [
                self::YESTERDAY,
                self::TODAY,
                self::WEEK,
                self::MONTH,
                self::YEAR
        ];

        private function calculateAvgFrequency($period, $ordersTotalCount) {
            $return = '';
            switch ($period) {
                case $this::TODAY:
                    $result = $ordersTotalCount / 24;
                    $return = number_format($result, 2, '.', ',') . '/hour';
                    break;
                case $this::WEEK:
                    $result = $ordersTotalCount / 7 ;
                    $return = number_format($result, 2, '.', ',') . '/day';
                    break;
                case $this::MONTH:
                    $result = $ordersTotalCount / 4;
                    $return = number_format($result, 2, '.', ',') . '/week';
                    break;
                case $this::YEAR:
                    $result = $ordersTotalCount  / 12;
                    $return = number_format($result, 2, '.', ',') . '/month';
                    break;
            }

            return $return;
        }

        private function periodToDate(string $period) {
            switch ($period) {
                case $this::YESTERDAY:
                    return date("Y-m-d 00:00:01", strtotime('yesterday'));
                    break;
                case $this::TODAY:
                    return date("Y-m-d 00:00:01", strtotime('now'));
                    break;
                case $this::WEEK:
                    return date("Y-m-d 00:00:01", strtotime('monday this week'));
                    break;
                case $this::MONTH:
                    return gmdate( 'Y-m-01 00:00:01' );
                    break;
                case $this::YEAR:
                    return gmdate( 'Y-01-01 00:00:01' );
                    break;
                default:
                    return gmdate( 'Y-m-01 00:00:01' );
            }
        }

        private function periodToDateEnd(string $period)
        {
            switch ($period) {
                case $this::YESTERDAY:
                    return date("Y-m-d 23:59:59", strtotime('yesterday'));
                    break;
                default:
                    return gmdate( 'Y-m-d 23:59:59' );
                    break;
            }
        }

        private function thousandsCurrencyFormat($value) {
            if($value > 1000) {
                $x = round($value);
                $x_number_format = number_format($x);
                $x_array = explode(',', $x_number_format);
                $x_parts = array('k', 'm', 'b', 't');
                $x_count_parts = count($x_array) - 1;
                $x_display = $x;
                $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                $x_display .= $x_parts[$x_count_parts - 1];

                return $x_display;
            }

            return $value;
        }

        private function ordersCount($period) {
            global $wpdb;
            $date_from = $this->periodToDate($period);
            $date_to   = $this->periodToDateEnd($period);
            $data      = false;

            if ($period !== false) {
                $query = $wpdb->prepare(
                    "
					SELECT count(*) as total_count FROM {$wpdb->prefix}wc_agents_commissions  
					WHERE {$wpdb->prefix}wc_agents_commissions.create_date >= %s 
					AND {$wpdb->prefix}wc_agents_commissions.create_date <= %s 
					AND {$wpdb->prefix}wc_agents_commissions.agent_id = %d
					AND {$wpdb->prefix}wc_agents_commissions.commission_status = 'paid'
					",
                    $date_from,
                    $date_to,
                    $this->agentId
                );
            } else {
                $query = $wpdb->prepare(
                    "
					SELECT count(*) as total_count FROM {$wpdb->prefix}wc_agents_commissions  
					WHERE {$wpdb->prefix}wc_agents_commissions.agent_id = %d
					AND {$wpdb->prefix}wc_agents_commissions.commission_status = 'paid'
					",
                    $this->agentId
                );
            }

            if ( $this->agentId ) {
                $data_result = $wpdb->get_results( $query );
            }

            if ( ! empty( $data_result ) ) {
                $data = $data_result[0]->total_count;
            }
            return $data;
        }

        private function totalOrderValue($period) {
            global $wpdb;

            $date_from = $this->periodToDate($period);
            $date_to   = $this->periodToDateEnd($period);
            $commission_status = 'paid';

            $result = $wpdb->get_results( $wpdb->prepare(
                "
                    SELECT SUM(pm.meta_value) as total_count FROM wp_wc_agents_commissions
                        LEFT JOIN {$wpdb->prefix}postmeta as pm on wp_wc_agents_commissions.order_id = pm.post_id
                        WHERE {$wpdb->prefix}wc_agents_commissions.create_date >= %s 
                        AND {$wpdb->prefix}wc_agents_commissions.create_date <= %s 
                        AND pm.meta_key = '_order_total'
					    AND {$wpdb->prefix}wc_agents_commissions.agent_id = %d
					    AND {$wpdb->prefix}wc_agents_commissions.commission_status = %s
					",
                $date_from,
                $date_to,
                $this->agentId,
                $commission_status
            ) );

            return $result[0]->total_count ?: 0;
        }

        private function avgOrderQuantity($period) {
            global $wpdb;

            $date_from = $this->periodToDate($period);
            $date_to   = $this->periodToDateEnd($period);
            $data      = false;

            if ( $this->agentId ) {
                $queryResult = $wpdb->get_results( $wpdb->prepare(
                    "
                    SELECT count(*) as items_count FROM {$wpdb->prefix}woocommerce_order_items
                    LEFT JOIN {$wpdb->prefix}wc_agents_commissions wwac on {$wpdb->prefix}woocommerce_order_items.order_id = wwac.order_id
                    WHERE wwac.create_date >= %s
                    AND wwac.create_date <= %s
                    AND wwac.agent_id = %d
                    AND wwac.commission_status = 'paid';
					",
                    $date_from,
                    $date_to,
                    $this->agentId
                ) );
            }

            if ( ! empty( $queryResult ) ) {
                if ($queryResult[0]->items_count) {
                    return $queryResult[0]->items_count;
                } else {
                    return 0;
                }
            }
            return 0;
        }

        private function pamojaOrdersRatio($period, $totalCount) {
            global $wpdb;
            $date_from = $this->periodToDate($period);
            $date_to   = $this->periodToDateEnd($period);
            $data      = false;

            if ( $this->agentId ) {
                $data_result = $wpdb->get_results( $wpdb->prepare(
                    "
					SELECT order_id, count(*) as total_count FROM {$wpdb->prefix}wc_agents_commissions
					LEFT JOIN {$wpdb->prefix}wp_postmeta as pm on {$wpdb->prefix}wc_agents_commissions
                        WHERE {$wpdb->prefix}wc_agents_commissions.create_date >= %s 
                        AND {$wpdb->prefix}wc_agents_commissions.create_date <= %s 
                        AND {$wpdb->prefix}wc_agents_commissions.agent_id = %d
                        AND {$wpdb->prefix}wc_agents_commissions.order_id = pm.post_id
                        AND pm.meta_value = 'pamoja'
					",
                    $date_from,
                    $date_to,
                    $this->agentId
                ) );
            }

            if ( ! empty( $data_result ) ) {
                $data = $data_result[0]->total_count;
            }
            if ($data > 0) {
              return ($data * 100 / $totalCount) . '%';
            }

            return '0 %';
        }

        private function commission(string $period, string $type) {
            global $wpdb;

            $date_from = $this->periodToDate($period);
            $date_to   = $this->periodToDateEnd($period);

            $data_result = $wpdb->get_results( $wpdb->prepare(
                "
                SELECT sum({$wpdb->prefix}wc_agents_commissions.commission_value) as total_sum
                FROM {$wpdb->prefix}wc_agents_commissions
                WHERE {$wpdb->prefix}wc_agents_commissions.create_date >= %s 
                AND {$wpdb->prefix}wc_agents_commissions.create_date <= %s 
                AND {$wpdb->prefix}wc_agents_commissions.commission_status = %s 
                AND {$wpdb->prefix}wc_agents_commissions.agent_id = %d
                ",
                $date_from,
                $date_to,
                $type,
                $this->agentId
            ) );

            if ( !empty( $data_result ) ) {
                if ($data_result[0]->total_sum){
                    return $this->thousandsCurrencyFormat($data_result[0]->total_sum);
                } else {
                    return 0;
                }
            }

            return 0;
        }

        private function calculateAvgOrderValue($value, $count)
        {
            if ($value > 0) {
                return 'KSh ' . $this->thousandsCurrencyFormat(($value / $count) );
            } else {
                return 'KSh 0';
            }
        }

        private function avgPamojaItemsPerOrder(int $itemsCount,  int $ordersCount)
        {
            if ($itemsCount != 0 && $ordersCount != 0) {
                return $itemsCount / $ordersCount;
            }

            return 0;
        }

        private function getPamojaItemsCount(): int
        {
            global $wpdb;

            if ( $this->agentId ) {
                $data_result = $wpdb->get_results( $wpdb->prepare(
                    "
                    SELECT count(*) as total_count FROM {$wpdb->prefix}woocommerce_order_items as wwoi
                        LEFT JOIN {$wpdb->prefix}wc_agents_commissions wwac on wwoi.order_id = wwac.order_id
                        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as wwoim 
                            on (wwoi.order_item_id = wwoim.order_item_id 
                                AND wwoim.meta_value = 'pamoja'
                                AND wwoim.meta_key = 'pa_pricing')
                        WHERE wwac.agent_id = %d
                          AND wwac.commission_status = 'paid'
					",
                    $this->agentId
                ) );
            }

            if ( !empty($data_result) && !empty($data_result[0]->total_count) ) {
                return (int) $data_result[0]->total_count;
            }

            return 0;
        }

        private function lifetimeTotalValuePamojaSales()
        {
            global $wpdb;

            if ( $this->agentId ) {
                $data_result = $wpdb->get_results( $wpdb->prepare(
                    "
                    SELECT sum(wwoim2.meta_value) as total_sum FROM {$wpdb->prefix}woocommerce_order_items as wwoi
                        LEFT JOIN {$wpdb->prefix}wc_agents_commissions wwac on wwoi.order_id = wwac.order_id
                        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as wwoim 
                            on (wwoi.order_item_id = wwoim.order_item_id 
                                AND wwoim.meta_value = 'pamoja'
                                AND wwoim.meta_key = 'pa_pricing')
                        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as wwoim2 
                            on (wwoi.order_item_id = wwoim2.order_item_id 
                                AND wwoim2.meta_key = '_line_total')
                        WHERE wwac.agent_id = %d
                          AND wwac.commission_status = 'paid'
					",
                    $this->agentId
                ) );
            }

            if ( !empty($data_result) && !empty($data_result[0]->total_sum) ) {
                return (int) $data_result[0]->total_sum;
            }

            return 0;
        }

        public function __construct(int $agentId)
        {
            $this->agentId = $agentId;
        }

        /**
         * @return StatisticObject[]
         */
        public function getStatistic(): array
        {
            $result = [];

            foreach ($this->periods as $period) {
                $obj = new StatisticObject();
                $obj->ordersCount = $this->ordersCount($period);
                $obj->totalOrderValue = $this->totalOrderValue($period);
                $obj->avgOrderValue =  $this->calculateAvgOrderValue($obj->totalOrderValue, $obj->ordersCount);

                $avgOrderQuantity = $this->avgOrderQuantity($period) / $obj->ordersCount;
                $obj->avgOrderQuantity = is_nan($avgOrderQuantity) ? 0 : number_format($avgOrderQuantity, 1);
                $obj->avgOrderFrequency = $this->calculateAvgFrequency($period, $obj->ordersCount);

                $obj->commissionPaid = $this->commission($period, 'paid');
                $obj->commissionPending = $this->commission($period, 'pending');
                $obj->pamojaOrdersPercentage = $this->pamojaOrdersRatio($period, $obj->ordersCount);

                $result[$period] = $obj;
            }

            return $result;
        }

        public function getLifetimeStatistic(): StatisticObject
        {
            $obj = new StatisticObject();

            $obj->ordersCount = $this->ordersCount(false);
            $obj->totalPamojaItemsCount = $this->getPamojaItemsCount();
            $obj->avgPamojaItemsPerOrder = $this->avgPamojaItemsPerOrder($obj->totalPamojaItemsCount, $obj->ordersCount);
            $obj->lifetimeTotalValueOfPamojaSales = $this->lifetimeTotalValuePamojaSales();

            return $obj;
        }
    }

    $agentService = new WC_Agent_Sales_Grn_All_Actions();
    $statistic = new AgentStatistics($agentService->is_agent());

    $data = $statistic->getStatistic();
    $lifeTimeData = $statistic->getLifetimeStatistic();
?>
<?php /*?>
<nav>
    <div class="nav nav-tabs periods" id="nav-tab" role="tablist">
        <?php foreach ($data as $key => $item) { ?>
            <div
                class="nav-item period <?= ($key == AgentStatistics::MONTH) ? 'active' : '';?>"
                id="nav-<?= $key; ?>-tab"
                data-toggle="tab"
                href="#nav-<?= $key; ?>"
                role="tab" aria-controls="nav-<?= $key; ?>"
                aria-selected="<?= ($key == AgentStatistics::MONTH) ? 'true' : 'false';?>"
            >
                <?= $key; ?>
            </div>
        <?php } ?>
    </div>
</nav>
<?php */?>
<div class="dropdown-btn-wrap" style="display: inline-block;float: right;">
	<button type="button" class="dropdown-toggle dropdown-btn period-dropdown-btn"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">This week</button>
	<div class="dropdown-menu">
		<div class="dropdown-menu-item" data-tabid="nav-today">Today</div>
		<div class="dropdown-menu-item" data-tabid="nav-yesterday">Yesterday</div>
		<div class="dropdown-menu-item active" data-tabid="nav-week">This week</div>
	</div>
</div>
<div class="tab-content" id="nav-tabContent">
<?php foreach ($data as $key => $item) { ?>
    <div class="tab-pane fade statsWrapper <?= ($key == AgentStatistics::MONTH) ? 'show  active' : ''; ?>" id="nav-<?= $key; ?>" role="tabpanel" aria-labelledby="nav-<?= $key; ?>-tab">
        <div class="stat">
            <label class="stat__heading"># of Orders</label>
            <h2 class="stat__value"><?= $item->ordersCount; ?></h2>
        </div>
        <div class="stat">
            <label class="stat__heading">Total order value</label>
            <h2 class="stat__value">KSh <?= $item->totalOrderValue; ?></h2>
        </div>
        <div class="stat">
            <label class="stat__heading">Avg Order Value</label>
            <h2 class="stat__value"><?= $item->avgOrderValue; ?></h2>
        </div>
        <div class="stat">
            <label class="stat__heading">Avg Order Qty</label>
            <h2 class="stat__value"><?= $item->avgOrderQuantity; ?></h2>
        </div>
        <?php if (false) { ?>
            <div class="stat">
                <label class="stat__heading">Avg order Frequency</label>
                <h2 class="stat__value"><?= $item->avgOrderFrequency; ?></h2>
            </div>
            <div class="stat">
                <label class="stat__heading">% of Pamoja Orders</label>
                <h2 class="stat__value"><?= $item->pamojaOrdersPercentage; ?></h2>
            </div>
        <?php } ?>

        <?php /**
        <div class="stat">
            <label class="stat__heading">Commission Paid</label>
            <h2 class="stat__value">KSh <?= $item->commissionPaid; ?></h2>
        </div>
        <div class="stat">
            <label class="stat__heading">Commission Pending</label>
            <h2 class="stat__value">KSh <?= $item->commissionPending; ?></h2>
        </div>
         php */ ?>

        <div class="stat">
            <label class="stat__heading">Avg Num of Pamoja Items Per Order</label>
            <h2 class="stat__value"><?= $lifeTimeData->avgPamojaItemsPerOrder; ?></h2>
        </div>
        <div class="stat">
            <label class="stat__heading">_Lifetime Total Num of Pamoja Items _</label>
            <h2 class="stat__value"><?= $lifeTimeData->totalPamojaItemsCount; ?></h2>
        </div>
        <div class="stat">
            <label class="stat__heading">_Lifetime Total Value (KSh) of Pamoja Sales _</label>
            <h2 class="stat__value">KSh <?= $lifeTimeData->lifetimeTotalValueOfPamojaSales; ?></h2>
        </div>
    </div>
<?php } ?>
</div>