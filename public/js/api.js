async function getDataFromApi(apiUrl) {
    await fetch(apiUrl)
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw response.reject();
        })
        .then((data) => result = { status: 'success', data})
        .catch((error) => result = { status: 'error', error })

    return result;
}

async function postDataApi(apiUrl,bodyData = null) {

    await fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(bodyData)
    })
        .then((response) => {
            if (response.ok) {
                return response;
            }
            throw response.reject();
        })
        .then((data) => result = { status: 'success', data})
        .catch((error) => result = { status: 'error', error })

    return result;
}

