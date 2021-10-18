#include<iostream>
#include<fstream>
using namespace std;
ifstream fin("titu.in");
int main()
{
int a[100],n=0;
int st=0 , dr, Smax = -2000000000 ,Smax1, S = 0, start, cnt=1;
 while (fin){
        fin>>a[n];
        n++;
   }
   for(int i = 0 ; i< n ; ++ i){
        Smax1 = Smax;
        S = S+a[i];
        if(S<0)
            start=i;
        if(S<a[i])
            S = a[i];
        if (Smax<S){
            Smax = S;
            st=start;
            dr = i;
            cnt=dr-st;
            }
        if (cnt<2)
        Smax = Smax1;

}
cout << Smax << endl;
   return 0;
}
