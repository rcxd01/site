
function getpet () {
var toyear = 1997;
var birthyear = document.frm.inyear.value;
var birthpet="Ox"
x = (toyear - birthyear) % 12
if ((x == 1) || (x == -11)) {
birthpet="��" }
else {
if (x == 0) {
birthpet="ţ" }
else {
if ((x == 11) || (x == -1)) {
birthpet="��" }
else {
if ((x == 10) || (x == -2)) {
birthpet="��" }
else {
if ((x == 9) || (x == -3)) {
birthpet="��" }
else {
if ((x == 8) || (x == -4)) {
birthpet="��" }
else {
if ((x == 7) || (x == -5)) {
birthpet="��" }
else {
if ((x == 6) || (x == -6)) {
birthpet="��" }
else {
if ((x == 5) || (x == -7)) {
birthpet="��" }
else {
if ((x == 4) || (x == -8)) {
birthpet="��" }
else {
if ((x == 3) || (x == -9)) {
birthpet="��" }
else {
if ((x == 2) || (x == -10)) {
birthpet="��" }
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

