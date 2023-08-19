<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <style>
       
form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f7f7f7;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}


label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}


input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
}


input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    padding: 10px 20px;
    cursor: pointer;
}


input[type="submit"]:hover {
    background-color: #0056b3;
}


br {
    clear: both;
}

    </style>
</head>
<body>
    <form method="post" action="submit_form.php">
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="subject">Subject:</label>
        <input type="text" name="subject" required><br>

        <label for="message">Message:</label><br>
        <textarea name="message" rows="4" cols="50" required></textarea><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
