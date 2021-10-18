#include<iostream>
#include <fstream>
using namespace std;
fstream fin("titu.in");

int cmls( int a[], int b[],int m,int n)
{
  int dp[m + 1][n + 1];
  for (int i = 0; i <= m; i++){
    for (int j = 0; j <= n; j++){
	    if (i == 0 || j == 0){
	              dp[i][j] = 0;
		 }
        else if (a[m - i] == b[n - j]){
	                dp[i][j] = 1 + dp[i - 1][j - 1];
	               }
            else{
	           int x = dp[i - 1][j];
               int y = dp[i][j - 1];
               int z = dp[i - 1][j - 1];
               dp[i][j] = max(x, max(y, z));
            }
		}
	}
return dp[m][n];
}
int main()
{
    int m,n;
    int a[100], b[100];
    fin>>m>>n;
    for(int i=0; i<m;i++)
        fin>>a[i];
    for(int i=0; i<n;i++)
        fin>>b[i];

    cout<<cmls(a, b, m, n);

return 0;
}
