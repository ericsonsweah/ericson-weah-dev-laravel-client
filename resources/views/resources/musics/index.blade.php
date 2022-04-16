@include('scripts.account.settings.info.musics.data')
<script>
  const musicsList = JSON.parse(musicsData)
  const musicList = document.getElementById('musicselect2')
  for(let music of musicsList.genres){
    let option = document.createElement('option')
    option.setAttribute('value', music)
    option.innerHTML = music
    musicList.appendChild(option)
  }

</script>
