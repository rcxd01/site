
function getpet () {
var toyear = 1997;
var birthyear = document.frm.inyear.value;
var birthpet="Ox"
x = (toyear - birthyear) % 12
if ((x == 1) || (x == -11)) {
birthpet="Êó" }
else {
if (x == 0) {
birthpet="Å£" }
else {
if ((x == 11) || (x == -1)) {
birthpet="»¢" }
else {
if ((x == 10) || (x == -2)) {
birthpet="ÍÃ" }
else {
if ((x == 9) || (x == -3)) {
birthpet="Áú" }
else {
if ((x == 8) || (x == -4)) {
birthpet="Éß" }
else {
if ((x == 7) || (x == -5)) {
birthpet="Âí" }
else {
if ((x == 6) || (x == -6)) {
birthpet="Ñò" }
else {
if ((x == 5) || (x == -7)) {
birthpet="ºï" }
else {
if ((x == 4) || (x == -8)) {
birthpet="¼¦" }
else {
if ((x == 3) || (x == -9)) {
birthpet="¹·" }
else {
if ((x == 2) || (x == -10)) {
birthpet="Öí" }
}
}
}
}
}
}
}
}
}
}
}
document.frm.birth.value = birthpet;
}

