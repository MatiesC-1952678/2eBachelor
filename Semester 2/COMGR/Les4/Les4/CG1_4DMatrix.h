// Matrix44.h: interface for the CMatrix44 class.
//
//////////////////////////////////////////////////////////////////////

#if !defined(AFX_MATRIX44_H__945F532B_C697_4665_BF4D_FFF06AAF0C18__INCLUDED_)
#define AFX_MATRIX44_H__945F532B_C697_4665_BF4D_FFF06AAF0C18__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000

#include "CG1_4DVector.h"

class CG1_4DMatrix  
{
public:
	CG1_4DMatrix();
	virtual ~CG1_4DMatrix();

	void LoadIdentity();

	void SetPerspectiveProjection(double d);

	CG1_4DVector operator*(const CG1_4DVector &v) const;

        CG1_4DMatrix& operator=(const CG1_4DMatrix &v);

	void RotateX(double angle);
	void RotateY(double angle);
	void RotateZ(double angle);

	void Translate(double x, double y, double z);

	void Scale(double sx, double sy, double sz);

private:
	double m_Values[16];
	/*
	 -			  -
	| 0	 4	 8	12 |
	| 1	 5	 9	13 |
	| 2	 6	10	14 |
	| 3	 7	11	15 |
	 -			  -
	*/
};

#endif // !defined(AFX_MATRIX44_H__945F532B_C697_4665_BF4D_FFF06AAF0C18__INCLUDED_)
