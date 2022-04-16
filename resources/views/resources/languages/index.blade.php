@include('resources.languages.data')
<script>
  const languagesList = JSON.parse(languagesData)
  const languageList = document.getElementById('languageselect2')
  for(let language in languagesList){
    let option = document.createElement('option')
    option.setAttribute('value', languagesList[language].name)
    option.innerHTML = `${languagesList[language].nativeName} (${languagesList[language].name})`
    languageList.appendChild(option)
  }

</script>
