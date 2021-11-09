var pages = [];
var shownPages = [];
var searchInput;

$(document).ready(()=>{
    searchInput = $("#searchpage");
    $.ajax({
        method: "get",
        url: "./getpages.php",
        dataType:"json",
        success: (data)=> {
            pages = data;
        }
    });

    searchInput.keydown((e)=>{
        if(e.keyCode == 13)
        {
            if(shownPages.length > 0) window.location = shownPages[0].url;
        }
    });

    searchInput.focusout(()=>{
        closeSearchResults();
        searchInput.val("");
    });

    searchInput.focus(()=>{
        openSearchResults();
    });

    searchInput.on('input',()=>{
        var pesqStr = $.trim(searchInput.val().toLowerCase());
        
        var pesquisa = pages.filter((pag)=>{
            return pag.titulo.toLowerCase().indexOf(pesqStr) != -1;
        });

        shownPages = pesquisa;

        updateSearchResults();
    });
});

function toggleSearchResults()
{
    $("#openSearchPageBtn").click();
}

function searchResultsIsOpen()
{
    return $("#resultList").length == 1
}

function openSearchResults()
{
    if(!searchResultsIsOpen())
    {
        toggleSearchResults();

        var interval1 = setInterval(() => {
            if(searchResultsIsOpen())
            {
                clearInterval(interval1);
                searchResultsOpened();
            }
        }, 1);
    }
}

function closeSearchResults()
{
    // if(searchResultsIsOpen())
    // {
    //     toggleSearchResults();
        
    //     var interval2 = setInterval(() => {
    //         if(searchResultsIsOpen())
    //         {
    //             clearInterval(interval2);
    //             searchResultsClosed();
    //         }
    //     }, 1);
    // }
}

function updateSearchResults()
{
    if(shownPages.length == 0)
    {
        // console.log($("#resultList").length);
        // $("#resultList").html("<li>aaaaaa</li>");
        // $("#resultList").html("<li class=\"flex\">\n            <a class=\"inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200\" href=\"pagamentos.php\">\n                <span>Pagamentos</span>\n            </a>\n        </li>");

        $("#resultList").html(`<li class="flex"><a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm text-red-700 font-semibold transition-colors duration-150 rounded-md"><span>Nenhuma página encontrada</span></a></li>`);
        return;
    }

    htmlItems = "";
    shownPages.forEach(page => {
        htmlItems +=
        `<li class="flex">
            <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="${page.url}">
                <span>${page.titulo}</span>
            </a>
        </li>`;
    });

    $("#resultList").html(htmlItems);
}

function searchResultsOpened()
{
    shownPages = pages;
    updateSearchResults();
}

function searchResultsClosed()
{

}

const click = (x, y) => {
    const ev = new MouseEvent('click', {
        'view': window,
        'bubbles': true,
        'cancelable': true,
        'screenX': x,
        'screenY': y
    });
    const el = document.elementFromPoint(x, y);
    el.dispatchEvent(ev);
}
