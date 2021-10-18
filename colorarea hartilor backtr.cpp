#include <iostream>
#include <fstream>
using namespace std;
 ifstream fin("harta.in");


int n,i,j,sol[10],a[10][10];
void afisareCulori();
void citireHarta(){
    fin >> n;
for (int i=1; i<=n; i++)
        for (int j=1; j<=n; j++)
            fin >> a[i][j];
}
int valid(int k)
{
    for (int i=1; i<k; i++)
        if (sol[k]==sol[i] &&
                a[i][k]==1) return 0;
    return 1;
}
void back(int k)
{
    int i;
    if (k==n+1)
    {
        for (int i=1; i<=n; i++)
            cout<<sol[i]<<" ";
            cout<<endl;
            afisareCulori();
        exit(EXIT_SUCCESS);
    }
    else
        for (i=1; i<=4; i++)
        {
            sol[k]=i;
            if (valid(k))
                back(k+1);
        }
}
void afisareCulori(){
    string culori[] ={"x","rosu", "verde", "mov", "galben"};
    for (int i=1;i<=9; i++)
        cout << culori[sol[i]] <<" ";
}
main()
{
    citireHarta();
    back(1);
}
