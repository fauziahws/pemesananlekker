#!/bin/bash

# Script to download sample product images
# This will download placeholder images from picsum.photos

echo "📥 Downloading sample product images..."

# Create directory if it doesn't exist
mkdir -p storage/app/public/products

# Download 8 sample images
for i in {1..8}; do
    echo "Downloading image $i of 8..."
    curl -L "https://picsum.photos/seed/product$i/600/400" -o "storage/app/public/products/sample-$i.jpg"
    sleep 0.5
done

echo "✅ Sample images downloaded successfully!"
echo "Run 'php artisan storage:link' to make them accessible."
