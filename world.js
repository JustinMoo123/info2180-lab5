window.onload = function() {
    const lookupBtn = document.getElementById("lookup");
    const lookupCitiesBtn = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");
    const countryInput = document.getElementById("country");

    
    lookupBtn.addEventListener("click", function() {
        const country = countryInput.value.trim();
        let url = "world.php";
        if (country !== "") {
            url += "?country=" + encodeURIComponent(country);
        }

        resultDiv.innerHTML = "<p>Loading...</p>";

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                resultDiv.innerHTML = "<p>Error: " + error + "</p>";
            });
    });

    
    lookupCitiesBtn.addEventListener("click", function() {
        const country = countryInput.value.trim();
        let url = "world.php?lookup=cities";
        if (country !== "") {
            url += "&country=" + encodeURIComponent(country);
        }

        resultDiv.innerHTML = "<p>Loading...</p>";

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                resultDiv.innerHTML = "<p>Error: " + error + "</p>";
            });
    });

    
    countryInput.addEventListener("keydown", function(e) {
        if (e.key === "Enter") {
            lookupBtn.click();
        }
    });
};
