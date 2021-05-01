// 3DVector.h: interface for the C3DVector class.
//
//////////////////////////////////////////////////////////////////////

#if !defined(AFX_4DVECTOR_H__E644534A_4102_428D_A443_F0D05D7FF1C4__INCLUDED_)
#define AFX_4DVECTOR_H__E644534A_4102_428D_A443_F0D05D7FF1C4__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000

class CG1_4DVector
{
public:
	void DivideByW();
	CG1_4DVector();
	CG1_4DVector(double X, double Y, double Z, double W = 1);
	virtual ~CG1_4DVector();

	double GetY() const;
	double GetX() const;
	double GetZ() const;
	double GetW() const;

	void SetXYZ(double NewX, double NewY, double NewZ);
	void SetXYZW(double NewX, double NewY, double NewZ, double NewW);

	CG1_4DVector& operator=(const CG1_4DVector &v);
	CG1_4DVector operator-();

private:
	double x;
	double y;
	double z;
	double w;
};

#endif // !defined(AFX_4DVECTOR_H__E644534A_4102_428D_A443_F0D05D7FF1C4__INCLUDED_)
