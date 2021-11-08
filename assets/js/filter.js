var allitems = [];
var shownitems = [];
var searchInput;

$(document).ready(()=>{
    searchInput = $("#searchpage");
    $.ajax({
        method: "get",
        url: "./getitems.php",
        dataType:"json",
        success: (data)=> {
            allitems = data;
        }
    });

    searchInput.keydown((e)=>{
        if(e.keyCode == 13)
        {
            if(shownitems.length > 0) window.location = shownitems[0].url;
        }
    });

    searchInput.focusout(()=>{
        closeResults();
        searchInput.val("");
    });

    searchInput.focus(()=>{
        openResults();
    });

    searchInput.on('input',()=>{
        var pesqStr = $.trim(searchInput.val().toLowerCase());
        
        var pesquisa = allitems.filter((pag)=>{
            return pag.titulo.toLowerCase().indexOf(pesqStr) != -1;
        });

        shownitems = pesquisa;

        updateResults();
    });
});

function toggleResults()
{
    $("#openSearchPageBtn").click();
}

function ResultsIsOpen()
{
    return $("#resultList").length == 1
}

function openResults()
{
    if(!ResultsIsOpen())
    {
        toggleResults();

        var interval1 = setInterval(() => {
            if(ResultsIsOpen())
            {
                clearInterval(interval1);
                ResultsOpened();
            }
        }, 1);
    }
}

function closeResults()
{
    if(ResultsIsOpen())
    {
        toggleResults();
        
        var interval2 = setInterval(() => {
            if(ResultsIsOpen())
            {
                clearInterval(interval2);
                ResultsClosed();
            }
        }, 1);
    }
}

function updateResults()
{

    htmlItems = "";
    shownitems.forEach(page => {
        htmlItems +=
        `<li class="flex">
            <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="${page.url}">
                <span>${page.titulo}</span>
            </a>
        </li>`;
    });

    $("#resultList").html(htmlItems);
}

function ResultsOpened()
{
    shownitems = allitems;
    updateResults();
}

function ResultsClosed()
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
