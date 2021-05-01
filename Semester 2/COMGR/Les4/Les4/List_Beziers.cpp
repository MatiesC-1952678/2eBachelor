#include "List_Beziers.h"

//--------------------------------------------------------------------
//Construction/destruction
//--------------------------------------------------------------------

List_Beziers::List_Beziers()
{

}

//--------------------------------------------------------------------

List_Beziers::~List_Beziers()
{

}

//--------------------------------------------------------------------

Object_Bezier* List_Beziers::GetBezier(int index)
{
    return m_Beziers[index];
}

//--------------------------------------------------------------------

int List_Beziers::GetSize()
{ 
    return m_Beziers.size(); 
}

//--------------------------------------------------------------------

void List_Beziers::AddBezier(Object_Bezier *bezier)
{ 
    m_Beziers.push_back(bezier); 
}

//--------------------------------------------------------------------
