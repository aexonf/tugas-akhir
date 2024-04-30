const EditButtons = document.querySelector("#EditButtons");
const edit = document.querySelector("#edit");

let replyButton = document.getElementById("replyButton")
let reply = document.getElementById("reply")

// untuk comment box angka
let commentBox = document.getElementById('comment');
let characterCount = document.getElementById('characterCount');

commentBox.addEventListener('input', function() {
  let count = commentBox.value.length;

  characterCount.innerHTML = 255 - count + ' characters left';
});



// Comment reply
EditButtons.addEventListener("click", () => {
    edit.classList.toggle("hidden")
})


// Edit
replyButton.addEventListener("click", () => {
    reply.classList.toggle("hidden")
})
