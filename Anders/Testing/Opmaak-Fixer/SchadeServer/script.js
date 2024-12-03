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
function EntryChange(EntryId) {
    if (document.getElementById(EntryId).classList.contains("Entry-Collapsed")) {
        document.getElementById(EntryId).classList.add("Entry-Extended");
        document.getElementById(EntryId).classList.remove("Entry-Collapsed");
    }
    else {
        document.getElementById(EntryId).classList.remove("Entry-Extended");
        document.getElementById(EntryId).classList.add("Entry-Collapsed");
    }
}