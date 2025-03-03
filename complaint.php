<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        header, footer {
            /* background-color: #007BFF; */
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .container1 {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px 30px;
            border-radius: 8px;
            max-width: 400px;
            margin: 20px auto;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #333333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
            text-align: left;
        }

        select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 10px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }


    </style>
    <script>
        function showLoader() {
            document.getElementById('loader').style.display = 'block';
        }
    </script>
</head>
<body>
    <!-- Include Header -->
    <?php include 'studheader.php'; ?>

    <div class="container1">
        <h1>Complaint Form</h1>
        <form method="post" action="complaintvalidation.php">
            <label for="complaint">Complaint:</label>
            <select name="complaint" id="complaint" required>
                <option value="hostel">Hostel</option>
                <option value="food">Food</option>
                <option value="library">Library</option>
            </select>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" placeholder="Describe your issue..." required></textarea>

            <input type="submit" value="Submit Complaint" onclick="showLoader()">
            <div id="loader" class="loader" style="display:none;"></div>
        </form>
    </div>

    <!-- Include Footer -->
    <?php include 'studfooter.php'; ?>
</body>
</html>
