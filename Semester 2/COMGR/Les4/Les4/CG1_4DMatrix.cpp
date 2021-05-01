// Matrix44.cpp: implementation of the CMatrix44 class.
//
//////////////////////////////////////////////////////////////////////

#include "CG1_4DMatrix.h"

#include <math.h>

#ifdef _DEBUG
#undef THIS_FILE
static char THIS_FILE[]=__FILE__;
#define new DEBUG_NEW
#endif

#define DEG2RAD 0.01746031746f

//////////////////////////////////////////////////////////////////////
// Construction/Destruction
//////////////////////////////////////////////////////////////////////

CG1_4DMatrix::CG1_4DMatrix()
{
    LoadIdentity();
}

CG1_4DMatrix::~CG1_4DMatrix()
{
}

void CG1_4DMatrix::LoadIdentity()
{
    m_Values[0] = m_Values[5] = m_Values[10] = m_Values[15] = 1.0f;
    
    m_Values[1] = m_Values[2] = m_Values[3] 
    = m_Values[4] = m_Values[6] = m_Values[7]
    = m_Values[8] = m_Values[9] = m_Values[11] 
    = m_Values[12] = m_Values[13] = m_Values[14] = 0.0f;
}

CG1_4DVector CG1_4DMatrix::operator*(const CG1_4DVector &v) const
{
    CG1_4DVector result;
    
    double newx = v.GetX() * m_Values[0] + v.GetY() * m_Values[4] + v.GetZ() * m_Values[8] + v.GetW() * m_Values[12];
    double newy = v.GetX() * m_Values[1] + v.GetY() * m_Values[5] + v.GetZ() * m_Values[9] + v.GetW() * m_Values[13];
    double newz = v.GetX() * m_Values[2] + v.GetY() * m_Values[6] + v.GetZ() * m_Values[10] + v.GetW() * m_Values[14];
    double neww = v.GetX() * m_Values[4] + v.GetY() * m_Values[7] + v.GetZ() * m_Values[11] + v.GetW() * m_Values[15];
    
    result.SetXYZW(newx, newy, newz, neww);
    
    return result;
}

CG1_4DMatrix& CG1_4DMatrix::operator=(const CG1_4DMatrix &v)
				     {
    for(int i = 0; i < 16; i++)
	m_Values[i] = v.m_Values[i];
    
    return *this;
}

/***********************************
TRANSFORMATIONS
************************************/

void CG1_4DMatrix::RotateX(double angle)
{
    double cosa = (double)cos(angle * DEG2RAD);
    double sina = (double)sin(angle * DEG2RAD);
    
    double m4 = m_Values[4];
    double m5 = m_Values[5];
    double m6 = m_Values[6];
    double m7 = m_Values[7];
    
    m_Values[4] = m4*cosa + m_Values[8]*sina;
    m_Values[5] = m5*cosa + m_Values[9]*sina;
    m_Values[6] = m6*cosa + m_Values[10]*sina;
    m_Values[7] = m7*cosa + m_Values[11]*sina;
    
    m_Values[8] = m_Values[8]*cosa - m4*sina;
    m_Values[9] = m_Values[9]*cosa - m5*sina;
    m_Values[10] = m_Values[10]*cosa - m6*sina;
    m_Values[11] = m_Values[11]*cosa - m7*sina;
}

void CG1_4DMatrix::RotateY(double angle)
{
    double cosa = (double)cos(angle * DEG2RAD);
    double sina = (double)sin(angle * DEG2RAD);
    
    double m0 = m_Values[0];
    double m1 = m_Values[1];
    double m2 = m_Values[2];
    double m3 = m_Values[3];
    
    m_Values[0] = m0*cosa - m_Values[8]*sina;
    m_Values[1] = m1*cosa - m_Values[9]*sina;
    m_Values[2] = m2*cosa - m_Values[10]*sina;
    m_Values[3] = m3*cosa - m_Values[11]*sina;
    
    m_Values[8] = m0*sina + m_Values[8]*cosa;
    m_Values[9] = m1*sina + m_Values[9]*cosa;
    m_Values[10] = m2*sina + m_Values[10]*cosa;
    m_Values[11] = m3*sina + m_Values[11]*cosa;
}

void CG1_4DMatrix::RotateZ(double angle)
{
    double cosa = (double)cos(angle * DEG2RAD);
    double sina = (double)sin(angle * DEG2RAD);
    
    double m0 = m_Values[0];
    double m1 = m_Values[1];
    double m2 = m_Values[2];
    double m3 = m_Values[3];
    
    m_Values[0] = m0*cosa + m_Values[4]*sina;
    m_Values[1] = m1*cosa + m_Values[5]*sina;
    m_Values[2] = m2*cosa + m_Values[6]*sina;
    m_Values[3] = m3*cosa + m_Values[7]*sina;
    
    m_Values[4] = m_Values[4]*cosa - m0*sina;
    m_Values[5] = m_Values[5]*cosa - m1*sina;
    m_Values[6] = m_Values[6]*cosa - m2*sina;
    m_Values[7] = m_Values[7]*cosa - m3*sina;
}

void CG1_4DMatrix::Translate(double x, double y, double z)
{
    m_Values[12] = m_Values[0]*x + m_Values[4]*y + m_Values[8]*z + m_Values[12];
    m_Values[13] = m_Values[1]*x + m_Values[5]*y + m_Values[9]*z + m_Values[13];
    m_Values[14] = m_Values[2]*x + m_Values[6]*y + m_Values[10]*z + m_Values[14];
    m_Values[15] = m_Values[3]*x + m_Values[7]*y + m_Values[11]*z + m_Values[15];
}

void CG1_4DMatrix::Scale(double sx, double sy, double sz)
{
    m_Values[0] = m_Values[0] * sx;
    m_Values[1] = m_Values[1] * sx;
    m_Values[2] = m_Values[2] * sx;
    m_Values[3] = m_Values[3] * sx;
    
    m_Values[4] = m_Values[4] * sy;
    m_Values[5] = m_Values[5] * sy;
    m_Values[6] = m_Values[6] * sy;
    m_Values[7] = m_Values[7] * sy;
    
    m_Values[8] = m_Values[8] * sz;
    m_Values[9] = m_Values[9] * sz;
    m_Values[10] = m_Values[10] * sz;
    m_Values[11] = m_Values[11] * sz;
}

/******************************
PROJECTIONS
*******************************/
void CG1_4DMatrix::SetPerspectiveProjection(double d)
{
    LoadIdentity();
    
    m_Values[11] = 1.0f / d;
    m_Values[15] = 0.0f;
}
