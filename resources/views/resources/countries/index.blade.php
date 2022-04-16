@include('resources.countries.data')
<script>
  const countriesList = JSON.parse(countriesData)
  console.log('country time', countriesList)
  const countryList = document.getElementById('country')
  for(let country of countriesList){
    let option = document.createElement('option')
    option.setAttribute('value', country.name)
    option.innerHTML = `${country.name} (${country.alpha3})`
    // console.log(document.getElementById('country'))
    // countryList.appendChild(option)
  }
</script>
