# 🎨 Custom Stubs untuk Laravel Modules + InertiaJS + Vue.js

Package custom stubs ini dirancang khusus untuk mempercepat development Laravel dengan nwidart/laravel-modules, InertiaJS, dan Vue.js 3.

## 📦 Isi Package

### Module Stubs
- `module.json.stub` - Konfigurasi module
- `provider.stub` - Service Provider dengan Inertia support
- `route-provider.stub` - Route Provider untuk web & API routes

### Controller Stubs
- `controller.stub` - Controller dengan CRUD methods lengkap dan Inertia integration

### Model Stubs
- `model.stub` - Model dengan traits, scopes, dan best practices

### Migration Stubs
- `migration.create.stub` - Migration template dengan kolom-kolom umum

### Route Stubs
- `web.stub` - Web routes dengan resource routing

### Vue.js View Stubs
- `index.vue.stub` - Index page dengan DataTable component
- `create.vue.stub` - Create page dengan form components
- `edit.vue.stub` - Edit page dengan form components
- `show.vue.stub` - Show/detail page
- `app.js.stub` - Module entry point untuk Vue.js

## 🚀 Cara Instalasi

### Opsi 1: Copy Manual
```bash
# Extract zip file
unzip custom-stubs.zip

# Copy ke project Laravel
cp -r custom-stubs stubs/
```

### Opsi 2: Symlink (Development)
```bash
# Extract zip
unzip custom-stubs.zip

# Buat symlink
ln -s /path/to/custom-stubs /path/to/laravel/stubs
```

### Opsi 3: Publish ke Vendor (Advanced)
```bash
# Copy stubs ke vendor nwidart
cp -r custom-stubs/* vendor/nwidart/laravel-modules/src/Commands/stubs/
```

## ⚙️ Konfigurasi

Edit `config/modules.php`:

```php
'stubs' => [
    'enabled' => true,
    'path' => base_path('stubs'),
    'files' => [
        'routes/web' => 'route/web.stub',
        'views/index' => 'view/index.vue.stub',
        'views/create' => 'view/create.vue.stub',
        'views/edit' => 'view/edit.vue.stub',
        'views/show' => 'view/show.vue.stub',
        'model' => 'model/model.stub',
        'controller' => 'controller/controller.stub',
        'migration/create' => 'migration/migration.create.stub',
        'module/module.json' => 'module/module.json.stub',
        'provider' => 'module/provider.stub',
        'route-provider' => 'module/route-provider.stub',
    ],
],
```

## 📝 Cara Menggunakan

### 1. Generate Module Baru
```bash
php artisan module:make NamaModule
```

### 2. Generate Controller
```bash
php artisan module:make-controller NamaController NamaModule
```

### 3. Generate Model
```bash
php artisan module:make-model NamaModel NamaModule
```

### 4. Generate Migration
```bash
php artisan module:make-migration create_nama_table NamaModule
```

## 🎯 Fitur yang Disediakan

### ✅ Controller
- CRUD methods lengkap (index, create, store, show, edit, update, destroy)
- Bulk delete method
- Search & filtering
- Sorting
- Pagination
- Inertia response

### ✅ Model
- HasFactory trait
- SoftDeletes trait
- Fillable attributes
- Casts
- Scopes (active, status, search)
- Template untuk relationships

### ✅ Vue.js Pages
- DataTable component integration
- Form components (FormInput, FormSelect, FormTextarea)
- Modal components
- Alert components
- Pagination component
- Button component
- Reusable dan customizable

### ✅ Migration
- Standard columns (id, timestamps, softDeletes)
- Common fields (name, status, description)
- Index templates
- Foreign key templates

## 🔧 Customization

### Mengubah Stub Templates
Edit file .stub sesuai kebutuhan:
```bash
# Edit controller stub
nano stubs/controller/controller.stub

# Edit vue index page stub
nano stubs/view/index.vue.stub
```

### Menambah Stub Baru
1. Buat file .stub baru di folder yang sesuai
2. Update config/modules.php untuk register stub baru
3. Generate module untuk test

## 📚 Placeholder Variables

Stubs menggunakan placeholder variables yang akan di-replace:

| Variable | Description | Example |
|----------|-------------|---------|
| `$MODULE$` | Module name (StudlyCase) | BlogModule |
| `$LOWER_NAME$` | Module name (lowercase) | blogmodule |
| `$STUDLY_NAME$` | Class name (StudlyCase) | BlogPost |
| `$CLASS$` | Full class name | BlogPostController |
| `$NAMESPACE$` | Full namespace | Modules\BlogModule\app\Http\Controllers |
| `$TABLE$` | Table name (snake_case plural) | blog_posts |

## 🎨 Materialize Template Integration

Stubs sudah dikonfigurasi untuk bekerja dengan Materialize Admin Template:
- Bootstrap 5 classes
- Boxicons icons
- Materialize color scheme
- Responsive design

## 🆘 Troubleshooting

### Stub tidak tergenerate
```bash
# Clear cache
php artisan config:clear
php artisan cache:clear

# Re-publish config
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --force
```

### Vue component tidak load
```bash
# Rebuild assets
npm run dev

# Check Vite config
cat vite.config.js
```

## 📖 Documentation

Lihat file `IMPLEMENTATION_GUIDE.md` untuk panduan lengkap implementasi.

## 💻 Requirements

- Laravel 12+
- PHP 8.2+
- nwidart/laravel-modules
- InertiaJS
- Vue.js 3
- Vite

## 📄 License

MIT License - Free to use and modify

## 🤝 Contributing

Feel free to submit issues and enhancement requests!

## 📞 Support

Untuk pertanyaan dan support, silakan buka issue di repository.

---

**Happy Coding! 🚀**
