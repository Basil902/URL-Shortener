<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    <header class="bg-blue-500">
        <h1>test</h1>
    </header>
    <button class="btn bg-green-600 ml-20" id="getuserbtn">Get User Data</button>

    {{-- the div in which the shorteneed link will be showed. User can click on it to naviate to original link --}}
    <div class="flex" id="messageDiv">
        <p id="UserData" class="border-1 p-6 text-white bg-blue-600 font-bold"></p>
        <p id="feedbackTag" class="bg-green-600 text-white font-bold text-2xl p-6"></p>
        <a href="http://localhost:5000/kdOlGB" id="linkTag">http://localhost:5000/kdOlGB</a>
    </div>

    <form action="http://localhost:5000/register" method="POST" id="registerForm">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="input-text">

        <label for="last_name" class="form-label">Last name:</label>
        <input type="text" name="last_name" id="last_name" class="input-text">

        <button type="submit" class="btn bg-blue-600 text-white">Submit</button>
    </form> 

    <form action="http://localhost:5001/shorten" method="POST" id="userInputForm">
        <label for="userInput" class="form-label">Enter Link:</label>
        <input type="text" name="userInput" id="userInput" class="input-text p-3">
        <button type="submit" class="btn bg-yellow-600">Shorten Link</button>
    </form>

    <div id="displayLinkDiv" class="flex m-3 flex-wrap items-center" hidden>
        <p class="mr-3">Shortend link:</p>
        <p id="generatedLinkTag" class="border p-3 bg-white rounded-lg mr-3"></p>
        <button class="btn bg-blue-500 hover:bg-blue-600 text-white font-bold" id="copyLinkBtn">Copy link</button>
    </div>

    <script>
        const btn = document.getElementById("getuserbtn");
        const userDataTag = document.getElementById("UserData");
        const feedbacktag = document.getElementById("feedbackTag");
        const registerForm = document.getElementById("registerForm");
        const userInputForm = document.getElementById("userInputForm");
        const msgDiv = document.getElementById("messageDiv");
        const linkTag = document.getElementById("linkTag");
        const generatedLinkTag = document.getElementById("generatedLinkTag");
        const displayLinkDiv = document.getElementById("displayLinkDiv");
        const copyLinkBtn = document.getElementById("copyLinkBtn");

        btn.addEventListener("click", () => {
            data = fetch("http://localhost:5000/getuser")
            .then(response=> response.json())
            .then(data => {
                userDataTag.innerHTML = `${data.name}`;
                console.log(data);
            })
        })

        registerForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('http://localhost:5000/register', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok) {
                feedbacktag.innerHTML = data.message;
                console.log(data.message)
            } else {
                feedbacktag.textContent = data.message;
            }
        } catch (error) {
            console.error('Error:', error);
            feedbacktag.textContent = 'An error occurred while submitting the form';
            }
        });

        userInputForm.addEventListener("submit", async function(event) {
            event.preventDefault();

            const formData = new FormData(this)

            try {
                const response = await fetch("http://localhost:5001/shorten", {
                    method: "POST",
                    body: formData
                });

                const data = await response.json();
                // einen bereits gekürzten Link aus dem Local Storage holen falls vorhanden
                const existing_link = localStorage.getItem("shortened_link");

                if (!response.ok) {
                    console.log("somethign went wrong!");
                    feedbacktag.innerHTML = data.message;
                    feedbacktag.innerHTML += ` Existing link: ${existing_link}`;
                } else {
                    feedbacktag.innerHTML = data.message;
                    // zeigt den neu erstellten link an.
                    generatedLinkTag.innerHTML = data.link;
                    displayLinkDiv.hidden = false;
                    localStorage.setItem("shortened_link", data.link);
                    // new_link.href = data.link;
                    // new_link.innerHTML = data.link;
                }
            } catch (error) {
                console.log(error);
            }
        });

        copyLinkBtn.addEventListener("click", () => {
            navigator.clipboard.writeText(generatedLinkTag.innerHTML)
            .then(() => {
                alert("Link copied to clipboard!");
            })
            .catch (error => {
                console.log("An error occurred while trying to copy link: ", error)
            });
        });

        // ### diese Funktion unnötig wenn man nicht mit anchor tags arbeitet, sodass der user direkt über den a tag weitergeleitet wird.
        // linkTag.addEventListener("click", async function() {

        //     try {
        //         const url = new URL("http://localhost:5000/getlink");
        //         // Query Params übergeben
        //         url.searchParams.append('linkquery', linkTag.href)
        //         const response = await fetch(url);

        //         const message = await response.json();

        //         if(!response.ok){
        //             feedbacktag.innerHTML = "Failed to fetch link from DB";
        //             console.log("message: ", message)
        //             return;
        //         } else {
        //             window.href.location = message.redirect_url
        //         }
        //     } catch (error) {
        //         console.log("error: ", error);
        //         return;
        //     }
        // });

    </script>
</body>
</html>