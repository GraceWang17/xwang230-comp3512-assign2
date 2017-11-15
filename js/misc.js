window.onload = function(){
    search();
    toggleFilter();
}
/*
*When the user clicks on the filter button, it should open up and the user
*should be able to see the filter options;
*/
function toggleFilter(){
    var filter = document.getElementById("employeesForm");
    var filterButton = document.getElementById('filterbtn');
    filterButton.addEventListener('click', function(e){
        filter.classList.toggle('hidden');
        if (filterButton.innerHTML == "Show Filter") {
            filterButton.innerHTML = "Hide Filter";
        } else {
            filterButton.innerHTML = "Show Filter";
        }
    });
}
//For simple Search
function search(){
    var btn = document.getElementById("search_btn");
    var bar = document.getElementById("search_bar");
    var search = document.getElementById('typeSearch')
    search.addEventListener('keydown', function(){
        let val = this.value
        if(val){
            //search thru db
            console.log(val)
        }
    })
}