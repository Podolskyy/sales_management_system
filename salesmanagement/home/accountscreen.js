// accountscreen.js

// Function to handle login and redirect
function handleLogin(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Get the selected role from the dropdown
    const role = document.getElementById('login-role').value;

    if (role === "clerk") {
        // Redirect to clerkscreen.html
        window.location.href = "../clerks/clerkscreen.html";
    } else {
        // Show an alert for other roles or invalid selections
        alert("This role is not supported yet or no role selected!");
    }
}

// Function to navigate back to the home screen
function navigateToHome() {
    window.location.href = "homescreen.html"; // Adjust the path as needed
}
