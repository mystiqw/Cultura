<?php
// ---- DB CONNECTION (YOUR CREDENTIALS) ----
$host = "localhost";
$user = "malgatay";
$pass = "b3CMxxaKEi8hSuAa";
$db   = "db_malgatay";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { 
    die("DB connection failed: " . $conn->connect_error); 
}

// fetch creators (users)
$users = $conn->query("SELECT user_id, name FROM users ORDER BY name");

// fetch post types  
$types = $conn->query("SELECT type_id, name FROM post_types ORDER BY name");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Post • Cultura</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="bar">
      <a class="brand" href="index.html">
        <span class="word">CULTURA</span>
        <span class="tag">Constructor University Community</span>
      </a>
      <nav class="nav">
        <a href="index.html">Home</a>
        <a href="event_search.php">Events</a>
        <a href="post_search.php">Posts</a>
        <a href="maintenance.html">Maintenance</a>
      </nav>
    </div>
  </header>

  <main class="container">
    <article class="paper">
      <h1>Share Your Culture</h1>
      <p class="lead">Submit a story, recipe, or cultural tradition to share with our community.</p>

      <form action="postsfeedback.php" method="post" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
          <div>
            <label for="creator_id" style="display: block; margin-bottom: 8px; font-weight: 600;">Author</label>
            <select name="creator_id" id="creator_id" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px;">
              <option value="" disabled selected>Select author</option>
              <?php while($u = $users->fetch_assoc()): ?>
                <option value="<?= (int)$u['user_id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          
          <div>
            <label for="type_id" style="display: block; margin-bottom: 8px; font-weight: 600;">Post Type</label>
            <select name="type_id" id="type_id" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px;">
              <option value="" disabled selected>Select type</option>
              <?php while($t = $types->fetch_assoc()): ?>
                <option value="<?= (int)$t['type_id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>

        <div style="margin-bottom: 24px;">
          <label for="title" style="display: block; margin-bottom: 8px; font-weight: 600;">Title</label>
          <input type="text" name="title" id="title" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px;" placeholder="Enter post title">
        </div>

        <div style="margin-bottom: 24px;">
          <label for="content" style="display: block; margin-bottom: 8px; font-weight: 600;">Content</label>
          <textarea name="content" id="content" rows="6" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px;" placeholder="Share your story, recipe, or cultural tradition..."></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
          <div>
            <label for="country" style="display: block; margin-bottom: 8px; font-weight: 600;">Country (optional)</label>
            <input type="text" name="country" id="country" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px;" placeholder="e.g., Morocco, Korea">
          </div>
          
          <div>
            <label for="theme" style="display: block; margin-bottom: 8px; font-weight: 600;">Theme (optional)</label>
            <input type="text" name="theme" id="theme" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px;" placeholder="e.g., Food, Tradition, Art">
          </div>
        </div>

        <div style="margin-bottom: 24px;">
          <label for="imgInput" style="display: block; margin-bottom: 8px; font-weight: 600;">Image (optional)</label>
          <input type="file" name="image" accept="image/*" id="imgInput" style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 8px;">
          <img id="preview" style="display:none; max-width: 200px; margin-top: 10px; border: 1px solid #eee; border-radius: 6px;">
        </div>

        <button class="cta" type="submit" style="width: 100%; text-align: center; justify-content: center;">Submit Post</button>
      </form>

      <p style="text-align: center; margin-top: 24px;">
        <a href="maintenance.html">← Back to Maintenance</a> | 
        <a href="post_search.php">Browse Posts</a>
      </p>
    </article>
  </main>

  <script>
    const inp = document.getElementById('imgInput');
    const prev = document.getElementById('preview');
    inp.addEventListener('change', () => {
      const [file] = inp.files || [];
      if (!file) return;
      prev.src = URL.createObjectURL(file);
      prev.style.display = 'block';
    });
  </script>
</body>
</html>
