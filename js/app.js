$(document).ready(function () {
    var item;
    var outputList = document.getElementById("list-output");
    var bookUrl = "https://www.googleapis.com/books/v1/volumes?q=";
    var placeHldr = `<img src="https://via.placeholder.com/150">`;
    var searchData;

    //listerner for search button
    $('#search').click(function () {
        outputList.innerHTML = "";
        searchData = $("#search-box").val();
        //handling empty search input field
        if (searchData === "" || searchData == null) {
            displayError();
        }
        else {
            $.ajax({
                url: bookUrl + searchData,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.totalItems === 0) {
                        alert("No results!.. try again");
                    }
                    else {
                        $("#title").animate({ 'margin-top': '5px' }, 1000);
                        $(".book-list").css("visibility", "visible");
                        displayResults(response);
                    }
                },
                error: () => {
                    alert("Something went wrong!...");
                }
            })
        }
        $("#search-box").val("");
    });

    function displayResults(res) {

        for (let i = 0; i < res.items.length - 1; i++) {
            item = res.items[i];
            title = item.volumeInfo.title;
            author = item.volumeInfo.authors;
            publisher = item.volumeInfo.publisher;
            ISBN = item.volumeInfo.industryIdentifiers[0].identifier;
            bookImg = (item.volumeInfo.imageLinks) ? item.volumeInfo.imageLinks.thumbnail : placeHldr;

            outputList.innerHTML += `<div class="col-6>` +
                formatOutput(bookImg, title, author, publisher, ISBN) +
                '</div>'
        }


    }

    function formatOutput(bookImg, title, author, publisher, ISBN){
        const htmlCard = `<div class="card style="width: 18rem;">
        <img class="card-img-top" src="${bookImg}" alt="Book Image">
        <div class="card-body">
          <h5 class="card-title">${title}</h5>
          <p class="card-text">ISBN: ${ISBN}</p>
          <p class="card-text">Author: ${author}</p>
          <p class="card-text">Publisher: ${publisher}</p>
        </div>
      </div>`
      return htmlCard;
    }

    //handling error for empty search box
   function displayError() {
    alert("search term can not be empty!")
  }
})