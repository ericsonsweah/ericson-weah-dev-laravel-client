
@include('scripts.account.settings.info.movies.data')
<script>
  const moviesList = JSON.parse(moviesData)
  const movieList = document.getElementById('moviesselect2')
  for(let movie of moviesList.movies){
    let option = document.createElement('option')
    option.setAttribute('value', movie.title)
    option.innerHTML = `${movie.title}`
    movieList.appendChild(option)
  }

</script>
