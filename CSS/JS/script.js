function placeBid() {

    let bid = document.getElementById("bidAmount").value;

    let currentBid = 48000;

    let message = document.getElementById("bidMessage");


    if (bid === "") {

        message.innerText = "Please enter a bid amount.";

        return;
    }


    if (Number(bid) <= currentBid) {

        message.innerText =
            "Your bid must be higher than ₹48,000.";

        return;
    }


    message.innerText =
        "Bid placed successfully! Your bid is ₹" + bid;
}