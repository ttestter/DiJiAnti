# Use official PHP CLI image
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Copy all project files to the container
COPY . .

# Expose the port Render uses
EXPOSE 10000

# Start PHP built-in server with your index.php
CMD ["php", "-S", "0.0.0.0:10000", "index.php"]
