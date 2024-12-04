function DateChange() {
    if (document.getElementById("Date").value === "Custom") {
        document.getElementById("CustomDateDiv").classList.add("Extended");
        document.getElementById("CustomDateDiv").classList.remove("Collapsed");
    }
    else {
        document.getElementById("CustomDateDiv").classList.remove("Extended");
        document.getElementById("CustomDateDiv").classList.add("Collapsed");
    }
}
function ToiletIDChange() {
    if (document.getElementById("ToiletID").value === "Custom") {
        document.getElementById("IDDiv").classList.add("Extended");
        document.getElementById("IDDiv").classList.remove("Collapsed");
    }
    else {
        document.getElementById("IDDiv").classList.remove("Extended");
        document.getElementById("IDDiv").classList.add("Collapsed");
    }
}
function EntryChange(EntryID) {
    let Subentry = document.getElementById("SubEntry"+EntryID);
    if (Subentry.classList.contains("SubEntry-Expanded")) {
        Subentry.classList.remove("SubEntry-Expanded");
        Subentry.classList.add("SubEntry-Collapsed");
    }
    else {
        Subentry.classList.add("SubEntry-Expanded");
        Subentry.classList.remove("SubEntry-Collapsed");
    }
    console.log("Test")
}
