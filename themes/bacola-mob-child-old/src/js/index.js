/* jshint esversion: 6 */

const jQuery = window.jQuery;

const clearSearchBtn = document.getElementById('clearSearch')
const mobSearchValue = document.getElementById('mobSearchValue')
const searchRecent = document.getElementById('search-recent')
const resultContent = document.getElementById('resultContent')

function findParentElement(el, tag) {
    while (el.parentNode) {
        el = el.parentNode;
        if (el.tagName === tag)
            return el;
    }
    return null;
}

function renderRecentSearch() {
    let latestLocalSearches = localStorage.getItem('latestLocalSearches');
    const recentSearchesContainer = document.getElementById('recentSearchContent')
    let latestItems = []

    if (latestLocalSearches) {
        latestItems = JSON.parse([latestLocalSearches])
    }

    let toRender = ''
    if (latestItems.length > 0) {
        for (const item of latestItems) {
            toRender += item
        }
        searchRecent.classList.remove('hide')
    } else {
        searchRecent.classList.add('hide')
    }
    recentSearchesContainer.innerHTML = toRender
}

function saveRecentSearch (results) {
    const resultLinks = document.getElementsByClassName('result-link')
    for (let i = 0; i < resultLinks.length ; i++) {
        resultLinks[i].addEventListener('click', function(event) {
            const target = event.target
            const stringRow = findParentElement(target, 'LI').outerHTML
            let latestLocalSearches = localStorage.getItem('latestLocalSearches');

            if (!latestLocalSearches) {
                localStorage.setItem('latestLocalSearches', JSON.stringify([stringRow]))
            }

            if (latestLocalSearches) {
                latestLocalSearches = JSON.parse(latestLocalSearches)
                if (!latestLocalSearches.includes(stringRow)) {
                    latestLocalSearches.unshift(stringRow)
                    if (latestLocalSearches.length > 5) {
                        latestLocalSearches.pop()
                    }
                    localStorage.setItem('latestLocalSearches', JSON.stringify(latestLocalSearches))
                }
            }
            window.location = target.closest('a').href
            event.preventDefault()
        },)
    }
}

function handleSearch (valueToSearch) {
    const data = {
        'wc-ajax': 'dgwt_wcas_ajax_search',
        s: valueToSearch
    };
    jQuery.get('/', data, function(response) {
        requestResult = JSON.parse(response)

        let toRender = ''
        let stringResults = []
        if (requestResult) {
            for (const item of requestResult.suggestions) {
                if (item.type === 'no-results') {
                    toRender = 'No results'
                    continue
                }
                toRender += `
                <li class="row">
                    <a href="${item.url}" class="result-link">
                        ${item.thumb_html}
                        <div>
                            <h6>${item.value}</h6>
                            <p>in: ${item.category}</p>
                        </div>
                    </a>
                </li>
                `
            }
        }
        const resultsContent = document.getElementById('resultContent')
        resultsContent.innerHTML = toRender
        saveRecentSearch()
    })
    .done(function () {
        searchRecent.classList.add('hide')
    });
}

let debounce;

clearSearchBtn.addEventListener('click', (event) => {
    searchRecent.classList.remove()
    mobSearchValue.value = ''
    renderRecentSearch()
    resultContent.innerHTML = ''
    mobSearchValue.focus()

})

mobSearchValue.addEventListener('input', (event) => {
    if (event.target.value.length < 3) {
        return false
    }

    clearTimeout(debounce)

    debounce = setTimeout(function () {
        handleSearch(event.target.value)
    }, 250)
})

renderRecentSearch()