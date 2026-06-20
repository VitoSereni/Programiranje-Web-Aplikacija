<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        form {
            width: 400px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .note {
            color: red;
            font-size: 12px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Registration Form</h1>

<form action="save.php" method="POST">

    <label>First Name *</label>
    <input type="text" name="name" placeholder="Your name.." required>

    <label>Last Name *</label>
    <input type="text" name="lastname" placeholder="Your last name.." required>

    <label>Your E-mail *</label>
    <input type="email" name="email" placeholder="Your e-mail.." required>

    <label>
        Username *
        <span class="note">(username must have min 5 and max 10 char)</span>
    </label>
    <input type="text" name="username" placeholder="Username.." minlength="5" maxlength="10" required>

    <label>
        Password *
        <span class="note">(password must have min 4 char)</span>
    </label>
    <input type="password" name="password" placeholder="Password.." minlength="4" required>

    <label>Country:</label>
    <select name="country">
        <option value="">molimo odaberite</option>
        <option value="Hrvatska">Hrvatska</option>
        <option value="Slovenija">Slovenija</option>
        <option value="Njemačka">Njemačka</option>
        <option value="Austrija">Austrija</option>
        <option value="Italija">Italija</option>
    </select>

    <button type="submit">Submit</button>

</form>

</body>
</html>