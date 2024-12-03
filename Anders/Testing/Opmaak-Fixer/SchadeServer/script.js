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
