
      document.getElementById("btn-east").addEventListener("click", () => {
        // document.getElementById("signin-signup-title").innerText = "Sign In";
        document.querySelector(".west").style.display = "none";
        document.querySelector(".east").style.display = "block";
      });
      document
        .getElementById("btn-west")
        .addEventListener("click", () => {
          // document.getElementById("signin-signup-title").innerText = "Sign Up";
          document.querySelector(".west").style.display = "block";
          document.querySelector(".east").style.display = "none";
        });
