function DateChange() {
    if (document.getElementById("Date").value === "Custom") {
        document.getElementById("CustomDiv").classList.add("Extended");
        document.getElementById("CustomDiv").classList.remove("Collapsed");
    }
    else {
        document.getElementById("CustomDiv").classList.remove("Extended");
        document.getElementById("CustomDiv").classList.add("Collapsed");
    }
}