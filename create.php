<?php
include 'includes/header.php';
?>

    <h1>Create post</h1>
    <form action="#">
        <div>
            <label>
                Post title:<br>
                <input type="text" placeholder="Post title">
            </label>
        </div>
        <div>
            <label>
                Post description:<br>
                <textarea placeholder="Post description"></textarea>
            </label>
        </div>
        <div>
            <label>
                Post content:<br>
                <textarea placeholder="Post content"></textarea>
            </label>
        </div>

        <div>
            <input type="submit" value="Create">
        </div>
    </form>

<?php
include 'includes/footer.php';
