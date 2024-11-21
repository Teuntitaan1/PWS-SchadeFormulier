function SwitchState(EntryID) {
    let EntryContent = document.getElementById("Entry"+EntryID);
    EntryContent.style.display === 'none' ? EntryContent.style.display = 'block' : EntryContent.style.display = 'none';
}