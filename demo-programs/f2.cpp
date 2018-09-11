#include <iostream>

using namespace std;

unsigned long factorial(unsigned long number)
{
    if (number <= 1) return 1;
    return number * factorial(number -1 );
}

int main()
{
    cout << factorial(12) << "\n";
    return 0;
}
