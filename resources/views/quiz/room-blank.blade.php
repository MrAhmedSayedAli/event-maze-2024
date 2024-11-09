<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cybersecurity Crossword - Room 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        .container h1 {
            font-size: 24px;
            color: #2f4f8f;
        }

        .message {
            font-size: 18px;
            margin: 15px 0;
        }

        input {
            padding: 10px;
            width: 80%;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #218838;
        }

        .pass-message {
            margin-top: 20px;
            color: green;
            font-weight: bold;
            display: none;
        }
        body.swal2-height-auto {
            height: 100% !important
        }
    </style>
</head>
<body style="height: 100vh!important;">

<div class="container">
    <h1>{!! $room_title ?? '' !!}</h1>
    {!!$title ?? ''!!}
    <input autocomplete="off" type="text" id="answer" placeholder="Enter your answer here" />
    <button onclick="checkAnswer()">Submit</button>
    <div class="pass-message" id="passMessage">{!! $hint ?? '' !!}</div>
</div>

<script>

    function checkAnswer() {
        const userAnswer = document.getElementById('answer').value.trim().toUpperCase();
        const correctAnswer = "{{$pass}}";

        if (userAnswer === correctAnswer) {
            document.getElementById('passMessage').style.display = 'block';
            document.getElementById('answer').value = "";

            const timerInterval = setInterval(function() {
                document.getElementById('passMessage').style.display = 'none';
                clearInterval(timerInterval);
            },1000*10);

        } else {
            document.getElementById('answer').value = "";
            //alert('Incorrect answer! Please try again.');
            window.Swal.fire({
                title: "Oops...",
                text: "Incorrect answer! Please try again.",
                icon: "error"
            });
        }
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
