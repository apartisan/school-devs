#include <iostream>

using namespace std;

int main()

{

   int X,n1,n2,n3;

   cin>>X;

   n1=X/100;

   n2=X%10;

   X=X/10;

   X=X*10+n1;

   n3=X%100;

   X=n2*100+n3;

   cout<<X;

   return 0;

}
