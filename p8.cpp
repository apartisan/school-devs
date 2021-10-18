#include<iostream>
using namespace std;
 int main() {
     int g1, m1, s1, g2, m2, s2, g, m, s;
     cin >> g1 >> m1 >> s1 >> g2 >> m2 >> s2;
     s = s1 + s2; m = m1 + m2; g = g1 + g2;
     if (s >= 60) { m = m + s / 60; s = s % 60; }
     if (m >= 60) { g = g + m / 60; m = m % 60; }
     cout << g << ' ' << m << ' ' << s; return 0; }
