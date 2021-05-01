#include "Object_Bezier.h"

//--------------------------------------------------------------------

Object_Bezier::Object_Bezier()
{

}

//--------------------------------------------------------------------

Object_Bezier::~Object_Bezier()
{

}

//--------------------------------------------------------------------

int Object_Bezier::getVertexIndex(int position)
{	
    return m_Vertices[position]; 
}

//--------------------------------------------------------------------

int Object_Bezier::getNrOfVertexIndices() 
{ 
    return m_Vertices.size(); 
}

//--------------------------------------------------------------------

CG1_Bezier* Object_Bezier::getBezier() 
{ 
    return &m_Bezier; 
}

//--------------------------------------------------------------------

void Object_Bezier::setNrOfSteps(int nr) 
{
    m_NrOfSteps = nr; 
}

//--------------------------------------------------------------------

void Object_Bezier::setMethod(Iteration_Method method) 
{
    m_Bezier.setIterationMethod(method); 
}

//--------------------------------------------------------------------	

void Object_Bezier::addVertex(int index, CG1_4DVector p )
{	
    m_Vertices.push_back(index); 
    m_Bezier.addCtrlPoint(p); 
}

//--------------------------------------------------------------------

void Object_Bezier::iterate() 
{ 
    m_Bezier.iterate(m_NrOfSteps); 
}

//--------------------------------------------------------------------
