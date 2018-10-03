// Copyright 2018 <niinimakim@webster.ac.th>
#include <iostream>
#include <string>
#include <sstream>
#include <cstring>
#include <stdlib.h>

class factorial {
    public:
    factorial(unsigned long number = 0) {
        mynum = number;
        int cumul = number;
        if (number <= 1) {
           myf = 1;
        } else {
           for (int i=number-1; i > 1; i--) cumul = cumul * i;
           myf = cumul;
        }
    }
    /** Gets the factorial
    *
    */
    unsigned long getf() {
        return myf;
    }
    std::string speak() {
         std::stringstream ss;
         ss << "The factorial of ";
         ss << mynum;
         ss << " is ";
         ss << myf;
         return ss.str();
    }

    private:
        unsigned long myf;
        unsigned long mynum;
};

int main(int argc, char *argv[]) {
    std::cout << "content-type: text/html" << std::endl << std::endl;
    std::cout << "<h1>Greatest program ever. Calculates factorials.</h1>" << std::endl;
    // first possibility: query coded in a string
    char *value = getenv("QUERY_STRING"); 
    int num = 0;
    if (value != NULL) {
        char *pch = std::strstr(value,"=");
        if (pch != NULL) {
           num = atoi( pch+1);
        }
    }
    // second: command line
    if (argc > 1) {
        std::stringstream firstparam(argv[1]);
        firstparam >> num;
    }
    // if either: num > 0
    if (num > 0) {
        factorial f1(num);
        std::cout << f1.speak() << "\n";
    } else {
        std::cout << "You should call this program with a parameter. By web: programname?number or  programname?f=number\n";
    }
    return 0;
}
