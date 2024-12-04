
This project is a web-based platform that combines the power of Google Maps and user-generated updates to provide real-time information on routes and weather conditions. It is designed to assist travelers in efficiently planning their journeys by offering dynamic routing options, live weather data, and insights from other users' experiences. The application not only empowers users to navigate better but also fosters a collaborative environment where users contribute live updates to benefit others.

The platform allows users to search for routes between a source and destination, with the option to add multiple waypoints for customized routing. It leverages the Google Maps JavaScript API to provide multiple route options, complete with visual mapping and detailed distance and duration information. Once a user selects a route, the application fetches real-time weather data for the selected route using a reliable weather API. This integration ensures users are well-informed about current conditions, helping them avoid potential delays caused by adverse weather or other factors.

To access advanced features like image uploads, users are required to log in or register on the platform. After logging in, users can upload route and weather-related images that provide real-time updates about the selected route. These images are displayed to other users, offering visual insights into traffic, weather, or incidents along the route. To ensure the relevance and accuracy of this information, only images uploaded within the last 12 hours are shown. This time restriction prevents outdated updates from misleading users, making the platform a reliable source for current route conditions.

The application also includes a community-driven rating system where users can rate the uploaded images based on their usefulness. Each rating contributes to the uploader's credit score, encouraging users to share valuable updates and rewarding them for their contributions. This feature fosters a sense of trust and accountability within the platform while ensuring that the most helpful content gets recognized.

The backend of the platform is powered by PHP and MySQL, ensuring efficient data management and user authentication. HTML, CSS, and JavaScript are used for the frontend to create a responsive and interactive user interface. The Google Maps JavaScript API is the backbone of the routing and mapping features, enabling precise route calculations and visualization. For weather updates, the platform integrates with a weather API, fetching live data for the selected route and displaying it in an easily comprehensible format.

Overall, this project is a powerful tool for travelers, commuters, and logistics operations, combining cutting-edge technologies and user contributions to create a dynamic, real-time navigation platform. With its integration of Google Maps and weather data, robust backend, and interactive user experience, the application stands as a practical and innovative solution for modern travel challenges.


STEPS:
Search for Routes:

Users begin by accessing the Google Maps interface integrated into the application.
They enter their source location, destination, and optional waypoints to customize their route.
The application uses the Google Maps JavaScript API to calculate and display multiple route options.


Select a Route:

Once the routes are displayed, users can review the options, including distance and estimated travel time.
Upon selecting a route, the application fetches real-time weather information for the chosen path using a weather API.
Weather data is displayed in a user-friendly format, giving users critical insights before their journey.


Login or Register to Upload Images:

To access advanced features like image uploads, users must log in or create an account.
The platform includes a secure registration system that stores user credentials in the backend database.
Once logged in, users can upload images of the selected route and associated weather conditions.


View and Rate Uploaded Images:

Uploaded images are made available for viewing by all users.
Other users can provide ratings for the images based on their relevance and accuracy.
Each rating contributes to the uploader's credit score, rewarding them for their helpful contributions.


Time-Limited Image Display:

To maintain the accuracy and relevance of updates, the system automatically removes images older than 12 hours.
This ensures that users only view the most current and actionable updates for their routes.
