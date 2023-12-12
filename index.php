<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

    <form id="contactForm">
        

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="Email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="Weight">Weight:</label>
        <input type="text" id="weight" name="weight" required><br>
        <label for="Height">Height:</label>
        <input type="text" id="height" name="height" required><br>
        <label for="Age">Age:</label>
        <input type="text" id="age" name="age" required><br>
        <label for="Vegan">Vegan:</label>
        <input type="text" id="vegan" name="vegan" required><br>
        <label for="Gender">Gender:</label>
        <input type="text" id="gender" name="gender" required><br>
        <label for="Goal">Goal:</label>
        <input type="text" id="goal" name="goal" required><br>
        <label for="Exercise">Activity Level:</label>
        <input type="text" id="exercise" name="exercise" required><br>

        <button type="button"  id="submitButton">Submit</button>
    </form>

    <div id="responseMessage"></div>
    
    <script>
        $(document).ready(function() {
            $("#submitButton").click(function(event) {
                event.preventDefault();
                // alert("chfghfg"); 
                var formData = {
                name: $("#name").val(),
                email: $("#email").val(),
                weight: $("#weight").val(),
                height: $("#height").val(),
                age: $("#age").val(),
                vegan: $("#vegan").val(),
                gender: $("#gender").val(),
                goal: $("#goal").val(),
                exercise: $("#exercise").val(),
                
            };

                $.ajax({
                    type: "POST",
                    url: "emal_send.php",
                    data: formData,
                    success: function(response) {
                        $("#responseMessage").html(response);
                    }
                });
            });
        });
    </script>

</body>
</html>
