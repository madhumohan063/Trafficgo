Route Finder and Live Updates Platform

This project is an interactive web application that combines the power of Google Maps and user-generated content to provide real-time information about routes and weather conditions. The platform is designed to assist users in planning their journeys efficiently while also contributing live updates for others.

Features:

Route Search and Selection:
Users can access Google Maps to search for routes between a source and destination.
The application allows adding multiple waypoints for more specific routing.
It provides multiple route options, enabling users to select the one that suits their needs best.
Upon selecting a route, the application displays weather conditions along the selected route.
User Login and Image Upload:
After route selection, users are prompted to log in or register to proceed further.
Logged-in users can upload route and weather images to share live updates about the selected route.
Uploaded images help other users gain insights into current route conditions.
Image Rating and Scoring System:
Other users can view the uploaded images and rate them based on their usefulness.
Each rating contributes to a credit score for the uploader, fostering a reputation system.
Time-Based Image Display:
To ensure the relevance of updates, the platform only displays images uploaded within the past 12 hours.
This limitation ensures users rely on recent and accurate information, especially for time-sensitive updates like accidents or weather conditions.
Why This Matters:

The platform addresses a critical gap in real-time route and weather updates. By integrating crowd-sourced data, it enhances the reliability of route information, making it especially valuable for commuters, travelers, and logistics operations.

For example:

A user uploads an image of an accident on a route. If the issue is resolved within 12 hours, the image automatically stops being displayed, ensuring users always see the most accurate information.
Technologies Used:

Frontend: HTML, CSS, JavaScript
Backend: PHP, MySQL
APIs: Google Maps JavaScript API, Weather API
How It Works:

Users search for routes using Google Maps with options for source, destination, and waypoints.
Multiple route suggestions are displayed; users select one to see the weather conditions.
After logging in or registering, users can upload route and weather images.
Other users can view these images, rate them, and contribute to the uploader's score.
Images older than 12 hours are automatically removed from display to maintain relevance.
