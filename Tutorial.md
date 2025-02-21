# DatoCMS PHP SDK: Complete Documentation 📚

**Version**: 1.0  
**Author**: Milton Vafana  
**License**: MIT  

---

## Table of Contents
1. [Overview](#overview)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Basic Usage](#basic-usage)
   - [Fetching Data](#fetching-data)
   - [Creating Content](#creating-content)
   - [Updating Content](#updating-content)
   - [Deleting Content](#deleting-content)
5. [Advanced Features](#advanced-features)
   - [File Uploads](#file-uploads)
   - [Error Handling](#error-handling)
6. [Examples](#examples)
7. [Troubleshooting](#troubleshooting)
8. [Best Practices](#best-practices)
9. [Support](#support)

---

## 1. Overview <a name="overview"></a>
A PHP SDK to interact with DatoCMS's GraphQL API. Designed for:
- Building PHP applications with content managed in DatoCMS
- Migrating content between environments
- Creating custom integrations

**Key Features**:
- ✅ Simple data fetching
- 🖼 File/asset uploads
- 🔄 Automatic retry logic
- 🛡️ Robust error handling

---

## 2. Installation <a name="installation"></a>

### Step 1: Install Composer
Skip if already installed:
```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

### Step 2: Create Project Folder
```bash
mkdir my-datocms-app
cd my-datocms-app
```

### Step 3: Install SDK
```bash
composer require nia-cloud-official/datocms-php-sdk
```

---

## 3. Configuration <a name="configuration"></a>

### Step 1: Get API Token
1. Log in to DatoCMS
2. Go to **Settings > API Tokens**
3. Copy **Read-only API token**

### Step 2: Create `.env` File
```bash
touch .env
```
Add your token:
```env
# .env
DATOCMS_API_TOKEN=your_token_here
```

### Step 3: Basic Setup File
Create `app.php`:
```php
<?php
require 'vendor/autoload.php';

use DatoCMS\Client;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize client
$client = new Client($_ENV['DATOCMS_API_TOKEN']);
```

---

## 4. Basic Usage <a name="basic-usage"></a>

### 4.1 Fetching Data <a name="fetching-data"></a>

**Example**: Get blog posts
```php
try {
    $result = $client->query('
        query {
            allPosts {
                id
                title
                content
            }
        }
    ');
    
    foreach ($result['allPosts'] as $post) {
        echo "Title: {$post['title']}\n";
    }
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
```

### 4.2 Creating Content <a name="creating-content"></a>
```php
$mutation = '
    mutation CreatePost($title: String!, $content: String!) {
        createPost(
            title: $title
            content: $content
        ) {
            id
        }
    }
';

$variables = [
    'title' => 'New Post',
    'content' => 'Hello World!'
];

$result = $client->query($mutation, $variables);
```

### 4.3 Updating Content <a name="updating-content"></a>
```php
$mutation = '
    mutation UpdatePost($id: ID!, $title: String!) {
        updatePost(
            id: $id
            title: $title
        ) {
            id
            title
        }
    }
';

$variables = [
    'id' => '123',
    'title' => 'Updated Title'
];
```

### 4.4 Deleting Content <a name="deleting-content"></a>
```php
$mutation = '
    mutation DeletePost($id: ID!) {
        deletePost(id: $id) {
            id
        }
    }
';

$variables = ['id' => '123'];
```

---

## 5. Advanced Features <a name="advanced-features"></a>

### 5.1 File Uploads <a name="file-uploads"></a>
```php
try {
    $file = $client->uploadFile('/path/to/image.jpg');
    echo "Uploaded file URL: {$file['url']}";
} catch (ApiException $e) {
    die("Upload failed: " . $e->getMessage());
}
```

### 5.2 Error Handling <a name="error-handling"></a>
Handle specific errors:
```php
try {
    // Your code here
} catch (AuthException $e) {
    die("❌ Invalid API token! Check your .env file");
} catch (RateLimitException $e) {
    sleep(60); // Wait 1 minute
    retry();
} catch (ApiException $e) {
    error_log($e->getMessage());
    die("A wild error appeared! 🐞");
}
```

---

## 6. Real-World Examples <a name="examples"></a>

### Example 1: Blog System
```php
// Get latest 5 posts with images
$result = $client->query('
    query {
        allPosts(orderBy: [date_DESC], first: 5) {
            title
            excerpt
            coverImage {
                url
                alt
            }
        }
    }
');

foreach ($result['allPosts'] as $post) {
    echo "<article>
        <img src='{$post['coverImage']['url']}' alt='{$post['coverImage']['alt']}'>
        <h2>{$post['title']}</h2>
        <p>{$post['excerpt']}</p>
    </article>";
}
```

### Example 2: User Profile Update
```php
$mutation = '
    mutation UpdateUser($id: ID!, $bio: String!) {
        updateUser(id: $id, bio: $bio) {
            id
            bio
        }
    }
';

$client->query($mutation, [
    'id' => 'user-456',
    'bio' => 'PHP developer passionate about CMS integrations'
]);
```

---

## 7. Troubleshooting <a name="troubleshooting"></a>

| Error | Solution |
|-------|----------|
| `401 Unauthorized` | 1. Check `.env` file<br>2. Verify token in DatoCMS dashboard |
| `Could not resolve host` | Check internet connection |
| `File upload failed` | 1. Verify file exists<br>2. Check file permissions |
| `Unexpected JSON error` | Validate your GraphQL query |

---

## 8. Best Practices <a name="best-practices"></a>
1. **Never commit `.env`**  
   Add to `.gitignore`:
   ```bash
   echo ".env" >> .gitignore
   ```
2. **Use query variables**  
   Avoid string interpolation in GraphQL queries
3. **Implement caching**  
   Example with Redis:
   ```php
   $client = new Client($_ENV['DATOCMS_API_TOKEN'], [
       'cache' => new RedisCache()
   ]);
   ```
4. **Validate inputs**  
   Sanitize data before sending to DatoCMS

---

## 9. Support <a name="support"></a>

**Need Help?**  
Contact: [miltonvafana@gmail.com](mailto:miltonvafana@gmail.com)

**Official Resources**:
- [DatoCMS Docs](https://www.datocms.com/docs)
---
