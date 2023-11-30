document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('weatherForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const cityNameInput = document.querySelector('.weather-search');
        const cityName = cityNameInput.value;

        if (cityName.trim() !== '') {
            fetch('weather.php', {
                method: 'POST',
                body: new URLSearchParams({
                    'city': cityName,
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
            })
            .then(response => response.text())
            .then(data => {
                const forecastContainer = document.querySelector('.weather-forecast');
                forecastContainer.innerHTML = data;
            })
            .catch(error => console.error('Error fetching weather data:', error));
        }
    });
});
