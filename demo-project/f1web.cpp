// Copyright 2018 <niinimakim@webster.ac.th>
#include <iostream>
#include <string>
#include <sstream>

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
    if (argc > 1) {
        //convert the first parameter (string) into integer
        std::stringstream firstparam(argv[1]);
        int num = 0;
        firstparam >> num;
        factorial f1(num);
        std::cout << f1.speak() << "\n";
    } else {
        std::cout << "You should call this program with a parameter. By web: programname?number\n";
    }
    return 0;
}
