// Copyright 2018 <niinimakim@webster.ac.th>
#include <iostream>
using namespace std;

unsigned long factorial(unsigned long number) {
    int cumul = number;
    if (number <= 1) return 1;
    for (int i=number-1; i>1; i--) cumul = cumul * i;
    return cumul;
}

int main() {
    cout << factorial(12) << "\n";
    return 0;
}
