// Retrieve URL parameters and display route information
const urlParams = new URLSearchParams(window.location.search);
document.getElementById("distance").textContent = urlParams.get("distance") || "N/A";
document.getElementById("duration").textContent = urlParams.get("duration") || "N/A";
document.getElementById("destination").textContent = urlParams.get("destination") || "N/A";

// Fetch username and score when page loads
fetch('get_user_score.php')
  .then(response => response.json())
  .then(data => {
    console.log("User data response:", data); // Log response for debugging

    if (data.loggedIn) {
      showProfile(data.username, data.score); // Show profile if logged in
    } else {
      toggleProfile(false); // Hide profile if not logged in
    }
  })
  .catch(error => console.error('Fetch error:', error));

function toggleProfile(isLoggedIn) {
  const logoutButton = document.getElementById('logoutButton');
  const usernameDisplay = document.getElementById('usernameDisplay');
  const userScore = document.getElementById('userScore');
  const loginRegisterButtons = document.getElementById('loginRegisterButtons');

  if (isLoggedIn) {
    usernameDisplay.style.display = 'block';
    userScore.style.display = 'block';
    loginRegisterButtons.style.display = 'none';
    logoutButton.classList.add('visible');
  } else {
    usernameDisplay.style.display = 'none';
    userScore.style.display = 'none';
    loginRegisterButtons.style.display = 'block';
    logoutButton.classList.remove('visible');
  }
}

function logout() {
  fetch('logout.php')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        window.location.href = 'next.html'; // Redirect to next.html after successful logout
      } else {
        console.error('Logout failed:', data);
      }
    })
    .catch(error => console.error('Logout error:', error));
}


function showProfile(username, score) {
  document.getElementById("usernameDisplay").textContent = `User: ${username}`;
  document.getElementById("userScore").textContent = `Score: ${score}`;
  toggleProfile(true);
}
