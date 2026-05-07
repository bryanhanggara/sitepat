#!/bin/bash

# Script untuk memperbaiki masalah storage di server
# Jalankan script ini di server setelah deploy

echo "🔧 Memperbaiki konfigurasi storage di server..."

# 1. Buat symbolic link untuk storage
echo "📁 Membuat symbolic link untuk storage..."
php artisan storage:link

# 2. Set permission yang benar untuk storage directory
echo "🔐 Mengatur permission untuk storage directory..."
chmod -R 755 storage/
chmod -R 755 public/storage/

# 3. Set ownership yang benar (ganti www-data dengan user web server Anda)
echo "👤 Mengatur ownership untuk storage directory..."
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data public/storage/

# 4. Clear cache
echo "🧹 Membersihkan cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 5. Optimize untuk production
echo "⚡ Mengoptimalkan aplikasi untuk production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Selesai! Masalah storage seharusnya sudah teratasi."
echo ""
echo "📋 Checklist yang perlu diperiksa:"
echo "1. Pastikan symbolic link storage sudah dibuat: ls -la public/storage"
echo "2. Pastikan permission storage benar: ls -la storage/"
echo "3. Pastikan file attachment ada di storage/app/public/ticket-attachments/"
echo "4. Test akses ke detail tiket dan download file"



