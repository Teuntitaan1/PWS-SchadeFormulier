function OpenFileInput() {
    const fileInput = document.getElementById('EvidenceInput');
    fileInput.click();
}
function CheckFileUpload() {
    const fileInput = document.getElementById('EvidenceInput');
    if (fileInput.files.length > 0) {
        document.getElementById('EvidenceCheckmark').style.opacity = '1';
        document.getElementById('EvidenceButton').style.opacity= '0.5';
    }
}