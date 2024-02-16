<html>
<head>
    <style>
        .copy-confirmation {
    display: none;
    /* Add more styling here */
}
</style>
</head>
<body>
<!-- Trigger/Open The Modal -->
<button id="myBtn">Donate XMR</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Click the button below to copy the XMR address:</p>
    <button onclick="copyToClipboard('YourXMRAddress', 'modal-xmr-confirmation')">Copy XMR Address</button>
    <span id="modal-xmr-confirmation" class="copy-confirmation">Copied!</span>
  </div>

</div>

</body>
</html>