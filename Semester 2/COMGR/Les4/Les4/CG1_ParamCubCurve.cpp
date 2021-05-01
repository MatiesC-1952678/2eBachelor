#include "CG1_ParamCubCurve.h"

//--------------------------------------------------------------------

CG1_ParamCubCurve::CG1_ParamCubCurve()
{

}

//--------------------------------------------------------------------

CG1_ParamCubCurve::~CG1_ParamCubCurve()
{
	m_CtrlPointVector.clear();
	m_PointVector.clear();
}

//--------------------------------------------------------------------

int CG1_ParamCubCurve::getNrOfCtrlPoints()
{ 
    return m_CtrlPointVector.size(); 
}

//--------------------------------------------------------------------

int CG1_ParamCubCurve::getNrOfPoints() 
{ 
    return m_PointVector.size(); 
}

//--------------------------------------------------------------------

CG1_4DVector CG1_ParamCubCurve::getCtrlPoint(int index) 
{ 
    m_CtrlIndex = index;
    return m_CtrlPointVector.at( m_CtrlIndex ); 
}

//--------------------------------------------------------------------

CG1_4DVector CG1_ParamCubCurve::getNextCtrlPoint()
{
    m_CtrlIndex++;
    return m_CtrlPointVector.at( m_CtrlIndex ); 
}

//--------------------------------------------------------------------

CG1_4DVector CG1_ParamCubCurve::getPoint(int index) 
{ 
    m_Index = index;
    return m_PointVector.at( m_Index ); 
}

//--------------------------------------------------------------------

CG1_4DVector CG1_ParamCubCurve::getNextPoint()
{
    m_Index++;
    return m_PointVector.at( m_Index ); 
}

//--------------------------------------------------------------------

void CG1_ParamCubCurve::addCtrlPoint( CG1_4DVector p ) 
{ 
    if( m_CtrlIndex < 4 ) 
	m_CtrlPointVector.push_back(p); 
    m_CtrlIndex++; 
}

//--------------------------------------------------------------------

void CG1_ParamCubCurve::clearCtrlPoints() 
{ 
    m_CtrlPointVector.clear(); 
    m_CtrlIndex = 0;
}

//--------------------------------------------------------------------

void CG1_ParamCubCurve::addPoint( CG1_4DVector p ) 
{ 
    m_PointVector.push_back(p); 
    m_Index++; 
}


//--------------------------------------------------------------------

void CG1_ParamCubCurve::clearPoints()
{ 
    m_PointVector.clear(); 
    m_Index = 0; 
}

//--------------------------------------------------------------------

void CG1_ParamCubCurve::evaluate( double t, CG1_4DVector & p )
{
	//todo: bereken x, y en z met behulp van Gb, Mb en T
	//p.SetXYZ(x, y, z);
}

//--------------------------------------------------------------------
