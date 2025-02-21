# DatoCMS PHP SDK 🚀

[![PHP Version](https://img.shields.io/badge/php-7.4%2B-blue)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)
[![Tests](https://github.com/yourname/datocms-php-sdk/actions/workflows/tests.yml/badge.svg)](https://github.com/yourname/datocms-php-sdk/actions)

A PHP client for interacting with DatoCMS's GraphQL API. Perfect for building PHP applications with content managed in DatoCMS.

**Features**:
- ✅ CRUD operations
- 🖼 File uploads
- 🔄 Automatic retry logic
- 🛡️ Robust error handling
- 📦 Composer ready

---

## Table of Contents
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Basic Usage](#basic-usage)
- [Advanced Features](#advanced-features)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

---

## Installation 📦

1. **Require via Composer**:
   ```bash
   composer require nia-cloud-official/datocms-php-sdk
   ```

2. **Create `.env` file**:
   ```env
   DATOCMS_API_TOKEN=your_api_token_here
   ```

3. **Get API token**:
   - Go to DatoCMS → Settings → API Tokens
   - Copy **Read-only API token**

---

## Quick Start ⚡

```php
<?php
require 'vendor/autoload.php';

use DatoCMS\Client;

$client = new Client(getenv('DATOCMS_API_TOKEN'));

try {
    // Get all blog posts
    $result = $client->query('
        query {
            allPosts {
                title
                content
            }
        }
    ');
    
    print_r($result);
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
```

---

## Basic Usage 📖

### Fetch Data
```php
$result = $client->query('
    query GetPost($id: ID!) {
        post(filter: {id: {eq: $id}}) {
            title
            content
        }
    }
', ['id' => '123']);
```

### Create Content
```php
$client->query('
    mutation CreatePost($title: String!) {
        createPost(title: $title) {
            id
        }
    }
', ['title' => 'New Post']);
```

### Upload File
```php
$file = $client->uploadFile('/path/to/image.jpg');
echo "Uploaded to: " . $file['url'];
```

---

## Advanced Features 🧠

### Error Handling
```php
try {
    // Your code here
} catch (DatoCMS\Exceptions\AuthException $e) {
    die("Invalid API token! 💀");
} catch (DatoCMS\Exceptions\RateLimitException $e) {
    sleep(60); // Wait 1 minute
} catch (Exception $e) {
    error_log($e->getMessage());
}
```

### Best Practices
1. **Cache responses**:
   ```php
   $client = new Client(getenv('DATOCMS_API_TOKEN'), [
       'cache' => new RedisCache()
   ]);
   ```
2. **Use query variables**
3. **Validate inputs before sending**

---

## Troubleshooting 🔧

| Error | Solution |
|-------|----------|
| `401 Unauthorized` | Check `.env` file |
| `429 Too Many Requests` | Implement retry logic |
| `File upload failed` | Check file permissions |
| `Unexpected response` | Validate GraphQL query |

---

## Contributing 🤝

1. Fork the repository
2. Create your feature branch:
   ```bash
   git checkout -b feature/amazing-feature
   ```
3. Commit changes:
   ```bash
   git commit -m 'Add amazing feature'
   ```
4. Push to branch:
   ```bash
   git push origin feature/amazing-feature
   ```
5. Open a Pull Request

---

## License 📄

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

**Need Help?**  
Email: [miltonhyndrex@gmail.com](mailto:miltonhyndrex@gmail.com)  
**Official Docs**: [DatoCMS Documentation](https://www.datocms.com/docs)
