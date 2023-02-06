function getFraction(price, type) {
    let modulus = 0;
    let floorModulus = 0;
    if (price > 4999) {

        if ((price % 25) == 0) {
            return price;
        } else {
            if (type == "up") {
                modulus = price % 25;
                floorModulus = Math.floor(modulus);
                return price + (25 - floorModulus);
            } else {
                modulus = price % 25;
                floorModulus = Math.floor(modulus);
                return price - floorModulus;
            }
        }

    } else if (price > 1999) {

        if ((price % 10) == 0) {
            return price;
        } else {
            if (type == "up") {
                modulus = price % 10;
                floorModulus = Math.floor(modulus);
                return price + (10 - floorModulus);
            } else {
                modulus = price % 10;
                floorModulus = Math.floor(modulus);
                return price - floorModulus;
            }
        }

    } else if (price > 499) {

        if ((price % 5) == 0) {
            return price;
        } else {
            if (type == "up") {
                modulus = price % 5;
                floorModulus = Math.floor(modulus);
                return price + (5 - floorModulus);
            } else {
                modulus = price % 5;
                floorModulus = Math.floor(modulus);
                return price - floorModulus;
            }
        }

    } else if (price > 199) {

        if ((price % 2) == 0) {
            return price;
        } else {
            if (type == "up") {
                modulus = price % 2;
                floorModulus = Math.floor(modulus);
                return price + (2 - floorModulus);
            } else {
                modulus = price % 2;
                floorModulus = Math.floor(modulus);
                return price - floorModulus;
            }
        }

    } else {
        return price;
    }
}

function incrementPriceStock(price, totalIncrement) {

    let fraction = 0;

    if (price > 4999) {

        fraction = 25;
    } else if (price > 1999) {

        fraction = 10;
    } else if (price > 499) {

        fraction = 5;
    } else if (price > 199) {

        fraction = 2;
    } else {
        fraction = 1;
    }

    for (i = 0; i < totalIncrement; i++) {
        price += fraction;
    }

    return price;
}

function getLowBodyPrice(openPrice, closePrice) {

    if (closePrice < openPrice) {
        return closePrice;
    } else {
        return openPrice;
    }
}

function getHighBodyPrice(openPrice, closePrice) {

    if (closePrice < openPrice) {
        return openPrice;
    } else {
        return closePrice;
    }
}

function printErrorMsg(msg) {
    $("#validation").find("ul").html('');
    $("#validation").css('display', 'block');
    $.each(msg, function (key, value) {
        $("#validation").find("ul").append('<li>' + value + '</li>');
    });
}