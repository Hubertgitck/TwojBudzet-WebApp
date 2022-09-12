async function getDataFromApi(apiUrl)
{
    await fetch(apiUrl)
    .then(response => response.json())
    .then((data) => result = data);

    return result;
}