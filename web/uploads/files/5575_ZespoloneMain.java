//zespolone.java
import java.util.*;
class Zespolone
{
	private double re;
	private double im;

	Zespolone(double r, double i)
		{
		re = r;
		im = i;
		}

	double getRe()
		{
		return re;
		}
	double getIm()
		{
		return im;
		}

	public Zespolone dodaj(Zespolone b)
		{
		Zespolone wynik = new Zespolone(re+b.getRe(), im+b.getIm());
		return wynik;	
		}

	public Zespolone pomnozPrzezConst(double c)
		{
		Zespolone wynik = new Zespolone(re*c, im*c);
		return wynik;	
		}
	public double modul()
		{
		return Math.sqrt(re*re+im*im);
		}

	public String toString()
		{
		return re+"+"+im+"i";
		}
	
}
public class ZespoloneMain
{
	public static void main(String[] args)
	{
	Zespolone tmp1 = new Zespolone(10,20);
	Zespolone tmp2 = new Zespolone(30,40);


	System.out.println("tmp1 = "+tmp1);
	System.out.println("tmp1 = "+tmp2);
	System.out.println("tmp1 + tmp2 = "+tmp1.dodaj(tmp2));
	System.out.println("2 * tmp1 = "+tmp1.pomnozPrzezConst(2));
	System.out.println("|tmp1| = "+tmp1.modul());
	}
}
