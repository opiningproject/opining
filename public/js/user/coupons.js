
function revealCode(event, link) {
    event.preventDefault();
    var code = link.getAttribute('data-code');

    // SVG icon to be appended
    var svgIcon = `<svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="0.5" width="10" height="12" rx="1.5" stroke="#F8B602" />
                    <rect x="3.5" y="3.5" width="10" height="12" rx="1.5" fill="white" stroke="#F8B602" />
                   </svg>`;

    // Change link text to code and append SVG icon
    link.innerHTML = `${svgIcon} ${code}`;
    
    // Update onclick event to copy code
    link.setAttribute('onclick', 'copyCode(event, this)');
}

function copyCode(event, link) {
    event.preventDefault();
    var code = link.textContent.trim();

    // Create a temporary textarea element to hold the code
    var tempTextarea = document.createElement("textarea");
    tempTextarea.value = code;
    document.body.appendChild(tempTextarea);

    // Select and copy the code
    tempTextarea.select();
    tempTextarea.setSelectionRange(0, 99999); // For mobile devices
    document.execCommand('copy');

    // Remove the temporary textarea
    document.body.removeChild(tempTextarea);

    // Change the link text to indicate success
    link.textContent = 'Copied!';

    // Reset the text back to the code after 2 seconds
    setTimeout(function() {
        var svgIcon = `<svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="10" height="12" rx="1.5" stroke="#F8B602" />
                        <rect x="3.5" y="3.5" width="10" height="12" rx="1.5" fill="white" stroke="#F8B602" />
                       </svg>`;
        link.innerHTML = `${svgIcon} ${code}`;
    }, 1500);
}

