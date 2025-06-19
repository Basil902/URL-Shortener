<x-layout>
    <div class="w-screen h-screen bg-blue-400 p-15">
        <div class="w-482 text-center">
            <div class="block w-auto ml-auto mr-auto mb-10 text-center">
                <h1 class="headLine text-white text-3xl font-bold m-6 ml-auto mr-auto">Your Ultimate Free URL Shortener — Simple, Fast, Powerful</h1>
            </div>
            <div class="flex items-start pl-98 mb-2">
                <p for="linkInput" class="text-white font-bold text-lg inline-block">Enter your link here:</p>
            </div>
            <form id="submitLinkForm" action="" method="post" class="flex items-center justify-center">
                <input type="text" class="input-text-form mt-0 mr-4" name="userInput" id="userInput" placeholder="https://example.com/my-long-url" required>
                {{-- send request with the ID of the currently logged in user --}}
                @auth
                <input type="text" name="userID" id="userID" value="{{Auth::id()}}" hidden>
                @endauth
                <button type="submit" id="submitLinkBtn" class="bg-amber-500 hover:bg-amber-600 text-white font-bold text-xl cursor-pointer rounded-md py-3.5 px-6">Shorten Link</button>
            </form>

            <div id="shortenedLinkDiv" hidden>
                <div class="flex items-start pl-98 mb-2 mt-10">
                    <p for="linkInput" class="text-white font-bold text-lg inline-block">Your shortendend link:</p>
                </div>
                <div action="" method="post" class="flex items-start ml-98 text-center w-auto">
                    <p id="shortenedLink" class="input-text-form mt-0 mr-4 py-4"></p>
                    <button type="button" id="copyLinkBtn" class="bg-amber-500 hover:bg-amber-600 text-white font-bold text-xl cursor-pointer rounded-md py-3.5 px-6">Copy Link</button>
                </div>
            </div>
            <p id="displayErrorTag" class="inline-block ml-auto mr-auto w-auto text-red-700 text-shadow-2xs font-bold text-xl m-3"></p>
        </div>
    </div>

    <script>
        const shortenedLinkDiv = document.getElementById("shortenedLinkDiv");
        const copyLinkBtn = document.getElementById("copyLinkBtn");
        const submitLinkForm = document.getElementById("submitLinkForm");
        const shortenedLinkTag = document.getElementById("shortenedLink");
        const displayErrorTag = document.getElementById("displayErrorTag");

        submitLinkForm.addEventListener("submit", async function (event) {
            event.preventDefault()

            // hide any displayed error messages before sending request
            displayErrorTag.hidden = true;

            const formData = new FormData(this)

            // if user is not logged in, redirect to login page
            if (!formData.get('userID')) {
                window.location.href = "http://localhost:80/login";
            }
            
            try {
                // change host to service name when working with docker
                const response = await fetch('http://localhost:5001/shorten', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                console.log(formData.get('userInput'));
                console.log(formData.get('userID'));
                // if status code 409 return the link that already exists in the DB
                if (response.status === 409) {
                    shortenedLinkDiv.hidden = false;
                    shortenedLinkTag.innerHTML = data.message;
                    return;
                } else if (response.status === 422) {
                    displayErrorTag.hidden = false;
                    displayErrorTag.innerHTML = data.message;
                    return;
                }

                if (!response.ok) {
                    console.log("Failed to shorten link")
                    displayErrorTag.innerHTML = response.message
                    return;
                }

                shortenedLinkDiv.hidden = false;
                shortenedLinkTag.innerHTML = data.generated_link;

            } catch (error) {
                console.log(error);
                displayErrorTag.innerHTML = "Connection to server failed"
                // Delete error message after 5 sec
                setTimeout(() => {
                    displayErrorTag.remove();
                }, 5000);
            }
        });

        copyLinkBtn.addEventListener("click", () => {
            const shortLink = document.getElementById("shortenedLink");
            // Extract only the link portion after the ": " in case there is additional text , and copy it to clipboard
            const extracted_link = shortLink.innerHTML.split(": ")
            const urlToCopy = extracted_link.length > 1 ? extracted_link[1]: extracted_link[0]

            navigator.clipboard.writeText(urlToCopy)
            .then(() => {
                alert("Link copied to clipboard!")
            })
            .catch(error => {
                console.log("Copying link failed: ", error)
            });
        });
    </script>
</x-layout>